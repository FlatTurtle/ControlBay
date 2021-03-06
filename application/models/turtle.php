<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Turtle extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'turtle_instance';
        $this->load->model('turtle_option');
    }

    public function get_all_turtles(){
        $this->db->where('allow_left', 1);
        $this->db->order_by('name','asc');
        $query = $this->db->get('turtle');
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        if($query->num_rows() < 1)
            return false;
        $turtles = $query->result();
        foreach($turtles as $turtle){
            if(isset($turtle->options)){
                $turtle->options = explode(',', $turtle->options);
            }
        }
        return $turtles;
    }

    public function get_by_infoscreen_id_with_options($screen_id)
    {
        $this->db->select("x.*, y.name, y.type, y.options");
        $this->db->where('x.infoscreen_id', $screen_id);
        $this->db->join('turtle y', 'x.turtle_id = y.id', 'left');
        $this->db->order_by('x.pane_id','asc');
        $this->db->order_by('x.order','asc');
        $query = $this->db->get($this->_table . ' x');
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        $result = $query->result();

        $result = $this->_bind_options($result);
        return $result;
    }

    public function get_by_infoscreen_id($screen_id)
    {
        $this->db->select("x.*, y.name, y.type");
        $this->db->join('turtle y', 'x.turtle_id = y.id', 'left');
        $this->db->order_by('x.pane_id','asc');
        $this->db->order_by('x.order','asc');
        $query = $this->db->get_where($this->_table . ' x', array('infoscreen_id' => $screen_id));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_pane_type_with_options($screen_id, $pane_type)
    {
        $this->db->select('x.*, y.name, y.type, y.options');
        $this->db->join('turtle y', 'x.turtle_id = y.id', 'left');
        $this->db->join('pane z', 'x.pane_id = z.id', 'left');
        $this->db->where('z.type', $pane_type);
        $this->db->where('x.infoscreen_id', $screen_id);
        $this->db->order_by('x.pane_id','asc');
        $this->db->order_by('x.order','asc');
        $query = $this->db->get($this->_table . ' x');
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        $result = $query->result();

        $result = $this->_bind_options($result);
        return $result;
    }

    public function get_id_with_options($id)
    {
        $this->db->select("x.*, y.name, y.type, y.options");
        $this->db->where('x.id', $id);
        $this->db->join('turtle y', 'x.turtle_id = y.id', 'left');
        $query = $this->db->get($this->_table . ' x');
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        $result = $query->result();

        $result = $this->_bind_options($result);
        return $result;
    }

    public function get_id_of_type($type){
        $this->db->where('type', $type);
        $query = $this->db->get('turtle');
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        if($query->num_rows() != 1)
            return false;
        $result = $query->row();
        return $result->id;
    }

    public function delete($turtle){
        // Remove turtle options
        $this->db->where('turtle_instance_id', $turtle->id);
        $this->db->delete('turtle_option');
        // Remove turtle instance
        $this->db->where('id', $turtle->id);
        $this->db->delete('turtle_instance');
    }

    private function _bind_options($results){
        foreach($results as $turtle){
            $options = explode(',', $turtle->options);
            $turtle->options = '';
            foreach ($options as $key) {
                $key = trim($key);
                $splitted = explode(':', $key);
                if(count($splitted) == 2){
                    $turtle->options[$splitted[0]] = $splitted[1];
                }else{
                    $turtle->options[$key] = '';
                }
            }

            $turtle_option = $this->turtle_option->get_for_turtle($turtle->id);
            if($turtle_option){
                foreach($turtle_option as $key => $value){
                    $turtle->options[$key] = $value;
                }
            }
        }
        return $results;
    }

    /**
     * Filter columns that are not allowed to be changed from row
     *
     * @param $data
     * @return mixed
     */
    function filter($data)
    {
        unset($data['id']);
        unset($data['turtle_id']);
        unset($data['turtle_instance_id']);
        unset($data['infoscreen_id']);
        unset($data['type']);
        return $data;
    }
}
