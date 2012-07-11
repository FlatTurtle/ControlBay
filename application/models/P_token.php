<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class P_token extends CI_Model
{

    var $table = 'P_tokens';

    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->result();
    }

    public function get_by_token($token)
    {
        $query = $this->db->get_where($this->table, array('token' => $token));
        return $query->result();
    }

    public function edit($id, $data)
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
