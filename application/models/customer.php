<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Model {
    var $table = 'customers';
    
    public function get_by_id($id)
	{
		$query = $this->db->get_where($this->table,array('id' => $id));
        /*foreach ($query->result() as $row)
        {
           echo $row->username;
        }*/
        return $query->result();
	}
    
    public function get_by_username($username)
	{
		$query = $this->db->get_where($this->table,array('username' => $username));
        return $query->result();
	}

    public function edit($id,$data)
	{
        $this->db->where('id', $id);
        unset($args_array['id']);
		$this->db->update($this->table, $data);
	}
    
    public function delete($id)
    {
        $this->db->delete($this->table, array('id' => $id)); 
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data); 
    }
}
