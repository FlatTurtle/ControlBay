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
        if($result[0]->customer_id != $this->authorization->customer_id){
			if($result[0]->alias != $this->authorization->alias){
				return false;
			}
		}
		return true;
	}

    public function get_by_customer_id($customer_id)
    {
        $query = $this->db->get_where($this->_table, array('customer_id' => $customer_id));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
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
					
			$discs['panes']->{$pane_id} = $pane;  
		}
		
		
		$this->load->model('jobtab');
		$jobs = $this->jobtab->get_by_infoscreen_id($result->id);
		foreach($jobs as $job){
			$job_id = $job->id;
			unset($job->id);
			unset($job->infoscreen_id);
			unset($job->job_id);
					
			$discs['jobs']->{$job_id} = $job;  
		}
		
		$discs['plugins'] = null;
		
		
		unset($discs['interface']->id);
		unset($discs['interface']->customer_id);
		unset($discs['interface']->alias);
		unset($discs['interface']->pincode);
		unset($discs['interface']->hostname);
		
		return json_encode($discs);
	}
	
	/** 
	 * Get the states of all plugin
	 */
	public function get_plugin_states($id){
		$this->db->select('type, state');
		$this->db->where('infoscreen_id', $id);
		$plugin_state = $this->db->get('plugin')->result();
		
		if($plugin_state){
			return $plugin_state;
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
		
		return 0;
	}

    /**
     * Filter primary keys from row
     */
    function filter($data)
    {
        unset($data['id']);
        unset($data['customer_id']);
        unset($data['alias']);
        unset($data['pincode']);
        return $data;
    }
}
