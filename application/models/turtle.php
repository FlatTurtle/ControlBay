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


    public function get_by_infoscreen_id_with_options($screen_id)
    {
        $this->db->where('x.infoscreen_id', $screen_id);
        $this->db->join('turtle y', 'x.turtle_id = y.id', 'left');
        $query = $this->db->get($this->_table . ' x');
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
		$result = $query->result();
		foreach($result as $turtle){
			$turtle->options = $this->turtle_option->get_for_turtle($turtle->id);
		}
        return $result;
    }

    public function get_by_infoscreen_id($screen_id)
    {
        $this->db->join('turtle y', 'x.turtle_id = y.id', 'left');
        $query = $this->db->get_where($this->_table, array('infoscreen_id' => $screen_id));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
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
