<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";

class InfoScreen extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'infoscreen';
    }
	
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
	
	public function export_json($alias){
		$query = $this->db->get_where($this->_table, array('alias' => $alias));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
		$result = $query->row();

		
		$discs['interface'] = $result;
	
		$this->load->model('turtle');
		$turtles = $this->turtle->get_by_screen_id_with_options($result->id);
		foreach($turtles as $turtle){
			$turtle_id = $turtle->id;
			unset($turtle->id);
			unset($turtle->infoscreen_id);
			unset($turtle->turtle_id);
			unset($turtle->turtle_option_id);
					
			$discs['turtles']->{$turtle_id} = $turtle;  
		}

		$this->load->model('pane');
		$panes = $this->pane->get_by_screen_id($result->id);
		foreach($panes as $pane){
			$pane_id = $pane->id;
			unset($pane->id);
			unset($pane->infoscreen_id);
			unset($pane->turtle_id);
			unset($pane->turtle_option_id);
					
			$discs['panes']->{$pane_id} = $pane;  
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
     * Filter primary keys from row
     *
     * @param $data
     * @return mixed
     */
    function filter($data)
    {
        unset($data['id']);
        unset($data['customer_id']);
        unset($data['alias']);
        unset($data['hostname']);
        return $data;
    }
}
