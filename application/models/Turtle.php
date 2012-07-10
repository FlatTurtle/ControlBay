<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Turtle extends CI_Model {
    var $table = 'turtles';

	public function get_by_customer_id($customer_id)
	{
		$query = $this->db->get_where($this->table,array('customer_id' => $customer_id));
        return $query->result();
	}

    public function get_by_id($id)
	{
		$query = $this->db->get_where($this->table,array('id' => $id));
        return $query->result();
	}

    public function get_by_alias($alias)
	{
		$query = $this->db->get_where($this->table,array('module' => $module));
        return $query->result();
	}

    public function get_by_title($title)
	{
		$query = $this->db->get_where($this->table,array('title' => $title));
        return $query->result();
	}
    public function get_by_order($order)
	{
		$query = $this->db->get_where($this->table,array('order' => $order));
        return $query->result();
	}

    public function get_by_group($group)
	{
		$query = $this->db->get_where($this->table,array('group' => $group));
        return $query->result();
	}

    public function get_by_source($source)
	{
		$query = $this->db->get_where($this->table,array('source' => $source));
        return $query->result();
	}
    
    public function get_by_colspan($colspan)
	{
		$query = $this->db->get_where($this->table,array('colspan' => $colspan));
        return $query->result();
	}

    public function edit($id,$data)
	{
        $this->db->where('id', $id);
        unset($args_array['id']);
        unset($args_array['infoscreen_id']);
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
