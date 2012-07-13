<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . "models/rest_model.php";
class Turtle extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'turtles';
    }

    public function get_by_customer_id($customer_id)
    {
        $query = $this->db->get_where($this->table, array('customer_id' => $customer_id));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
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
        unset($data['infoscreen_id']);
        unset($data['module']);
        return $data;
    }
}