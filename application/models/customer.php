<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Customer extends REST_Model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'customers';
    }


    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->_table, array('id' => $id));
        /*foreach ($query->result() as $row) {
            echo $row->username;
        }*/
        return $query->result();
    }

    public function get_by_username($username)
    {
        $query = $this->db->get_where($this->_table, array('username' => $username));
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
        // TODO: Implement filter() method.
    }
}
