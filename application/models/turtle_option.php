<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Turtle_option extends REST_Model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'turtle_option';
    }

	public function get_for_turtle($turtle_id){
        $this->db->where('x.turtle_instance_id', $turtle_id);
        $query = $this->db->get($this->_table . ' x');
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
		$result =  array();
		foreach($query->result() as $turtle_option){
			$result[$turtle_option->key] = $turtle_option->value;
		}
		
		return $result;
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
        unset($data['key']);
        return $data;
    }
}
