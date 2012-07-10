<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InfoScreen extends CI_Model {
    var $table = 'infoscreens';

	public function get_by_customer_id($customer_id)
	{
		$query = $this->db->get_where($this->table,array('customer_id' => $customer_id));
        return $query->result();
	}

    public function get_by_id($id)
	{
		$query = $this->db->get_where($this->table,array('id' => $id));
        foreach ($query->result() as $row)
        {
           echo $row->title;
        }
        return $query->result();
	}

    public function get_by_alias($alias)
	{
		$query = $this->db->get_where($this->table,array('alias' => $alias));
        foreach ($query->result() as $row)
        {
           echo $row->title;
        }
        return $query->result();
	}

    public function get_by_title($title)
	{
		$query = $this->db->get_where($this->table,array('title' => $title));
        foreach ($query->result() as $row)
        {
           echo $row->title;
        }
        return $query->result();
	}
    public function get_by_lang($lang)
	{
		$query = $this->db->get_where($this->table,array('lang' => $lang));
        foreach ($query->result() as $row)
        {
           echo $row->title;
        }
        return $query->result();
	}

    public function get_by_hostname($hostname)
	{
		$query = $this->db->get_where($this->table,array('hostname' => $hostname));
        foreach ($query->result() as $row)
        {
           echo $row->title;
        }
        return $query->result();
	}

    public function edit($id,$data)
	{
        $this->db->where('id', $id);
        unset($args_array['id']);
        unset($args_array['customer_id']);
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
