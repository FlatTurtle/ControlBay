<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Turtle_options extends CI_Model
{
    var $table = 'turtle_options';

    public function get_by_turtle_id($turtle_id)
    {
        $query = $this->db->get_where($this->table, array('turtle_id' => $turtle_id));
        return $query->result();
    }

    public function get_by_key($key)
    {
        $query = $this->db->get_where($this->table, array('key' => $key));
        return $query->result();
    }

    public function get_by_value($value)
    {
        $query = $this->db->get_where($this->table, array('value' => $value));
        return $query->result();
    }

    public function edit($turtle_id, $data)
    {
        $this->db->where('turtle_id', $turtle_id);
        unset($args_array['turtle_id']);
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
