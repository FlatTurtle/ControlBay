<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";

class Infoscreen extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'infoscreen';
    }

    /**
     * Check if authenticated user is owner of the infoscreen
     */
    public function isOwner($alias){
        $result = $this->get_by_alias($alias);
        $result = $result[0];

        if($this->authorization->role == AUTH_SUPER_ADMIN){
            return true;
        }else{
            # ID based
            $this->db->where(array('user_id' => $this->authorization->user_id,
                                         "infoscreen_id" => $result->id));
            $owner_id = $this->db->get("infoscreen_link");
            # GROUP based
            $this->db->where(array('user_id' => $this->authorization->user_id,
                                         "infoscreen_group" => $result->group));
            $this->db->where("infoscreen_group IS NOT NULL");
            $owner_group = $this->db->get("infoscreen_link");
            if( $owner_id->num_rows() == 1 ||
                $owner_group->num_rows() == 1 ||
                $result->alias == $this->authorization->alias ){
                return true;
            }
        }
        return false;
    }

    public function get_by_user_id($user_id)
    {
        $this->load->model('user');
        $user = $this->user->get($user_id);
        $user = $user[0];
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());

        $infoscreens = array();
        $query = $this->db->get_where("infoscreen_link", array('user_id' => $user_id));

        if($this->authorization->role == AUTH_SUPER_ADMIN){
            // User is superadmin, get all
            $infoscreens = $this->db->get($this->_table);
            $infoscreens = $infoscreens->result();
        }else{
            $auth_rules = $query->result();
            foreach($auth_rules as $auth_rule){
                if($auth_rule->infoscreen_id != NULL){
                    // ID based authentication
                    array_push($infoscreens, $this->db->get_where($this->_table, array('id' => $auth_rule->infoscreen_id))->row());
                }elseif($auth_rule->infoscreen_group != NULL){
                    // Group based authentication
                    $infoscreens = $this->db->get_where($this->_table, array('group' => $auth_rule->infoscreen_group));
                    $infoscreens = $infoscreens->result();
                }
            }
        }

        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $infoscreens;
    }

    public function get_by_alias($alias)
    {
        $query = $this->db->get_where($this->_table, array('alias' => $alias));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_title($title)
    {
        $query = $this->db->get_where($this->_table, array('title' => $title));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_hostname($hostname)
    {
        $query = $this->db->get_where($this->_table, array('hostname' => $hostname));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_pin($pincode)
    {
        $this->db->where('pincode', $pincode);
        $query = $this->db->get($this->_table);
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    /**
     * Generate the DISCS JSON
     */
    public function export_json($alias){
        $query = $this->db->get_where($this->_table, array('alias' => $alias));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        $result = $query->row();

        $discs['interface'] = $result;
        $discs['plugins'] = $this->get_plugin_states($result->id);

        $this->load->model('turtle');
        $turtles = $this->turtle->get_by_infoscreen_id_with_options($result->id);
        foreach($turtles as $turtle){
            $turtle_id = $turtle->id;
            unset($turtle->id);
            unset($turtle->infoscreen_id);
            unset($turtle->turtle_id);
            unset($turtle->turtle_option_id);
            $turtle->pane = $turtle->pane_id;
            unset($turtle->pane_id);

            if(!isset($discs['turtles'])){
                $discs['turtles'] = new stdClass();
            }
            $discs['turtles']->{$turtle_id} = $turtle;
        }

        $this->load->model('pane');
        $panes = $this->pane->get_by_infoscreen_id($result->id);
        foreach($panes as $pane){
            $pane_id = $pane->id;
            unset($pane->id);
            unset($pane->infoscreen_id);
            unset($pane->turtle_id);
            unset($pane->turtle_option_id);

            if(!isset($discs['panes'])){
                $discs['panes'] = new stdClass();
            }
            $discs['panes']->{$pane_id} = $pane;
        }

        // Check if master power is set
        $master_power_state = $this->get_plugin_state($result->id, "masterPower");

        $this->load->model('jobtab');
        $jobs = $this->jobtab->get_by_infoscreen_id($result->id);
        foreach($jobs as $job){
            $job_id = $job->id;
            unset($job->id);
            unset($job->infoscreen_id);
            unset($job->job_id);

            if(!isset($discs['jobs'])){
                $discs['jobs'] = new stdClass();
            }

            if($master_power_state && $master_power_state == 1 &&
                ($job->name == "screen_on" || $job->name == "screen_off")){
                // don't add job if master power state is on
                // and if the job is turning the screen on or off
            }else{
                $discs['jobs']->{$job_id} = $job;
            }

        }


        unset($discs['interface']->id);
        unset($discs['interface']->user_id);
        unset($discs['interface']->pincode);

        return json_encode($discs);
    }

    /**
     * Get the states of all plugin
     */
    public function get_plugin_states($id){
        $this->db->select('type, state');
        $this->db->where('infoscreen_id', $id);
        $plugin_states = $this->db->get('plugin')->result();

        if($plugin_states){
            $data = '';
            foreach($plugin_states as $plugin_state){
                $data[$plugin_state->type] = $plugin_state->state;
            }

            return $data;
        }

        return null;
    }

    /**
     * Get the state of a plugin
     */
    public function get_plugin_state($id, $type){
        $this->db->select('state');
        $this->db->where('infoscreen_id',$id);
        $this->db->where('type', strtolower($type));
        $plugin_state = $this->db->get('plugin')->row();

        if($plugin_state){
            return $plugin_state->state;
        }

        return null;
    }

    /**
     * Set the state of a plugin
     */
    public function set_plugin_state($id, $type, $state){
        $data['state'] = $state;
        if($this->get_plugin_state($id, $type) == null){
            $data['infoscreen_id'] = $id;
            $data['type'] = strtolower(trim($type));
            return $this->db->insert('plugin',$data);
        }else{
            $this->db->where('infoscreen_id',$id);
            $this->db->where('type', strtolower($type));
            return $this->db->update('plugin',$data);
        }
    }

    /**
     * Disable a plugin
     */
    public function disable_plugin($id, $type){
        $this->set_plugin_state($id, $type, 0);
    }

    /**
     * Filter primary keys from row
     */
    function filter($data)
    {
        unset($data['id']);
        return $data;
    }
}
