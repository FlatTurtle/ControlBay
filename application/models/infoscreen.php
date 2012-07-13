<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class InfoScreen extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'infoscreens';
    }


    public function get_by_customer_id($customer_id)
    {
        $query = $this->db->get_where($this->table, array('customer_id' => $customer_id));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_alias($alias)
    {
        $query = $this->db->get_where($this->table, array('alias' => $alias));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_title($title)
    {
        $query = $this->db->get_where($this->table, array('title' => $title));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_hostname($hostname)
    {
        $query = $this->db->get_where($this->table, array('hostname' => $hostname));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_pin($pincode)
    {
        $query = $this->db->get_where($this->table, array('pincode' => $pincode));
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
        unset($data['customer_id']);
        unset($data['alias']);
        unset($data['hostname']);
        return $data;
    }
}
