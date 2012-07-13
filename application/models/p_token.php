<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class P_token extends REST_model
{
    // expiration in minutes
    const TABLET_EXPIRATION = 9999999999;//TODO
    const MOBILE_EXPIRATION = 600;

    function __construct()
    {
        parent::__construct();
        $this->_table='P_tokens';
    }


    public function get_by_screen_id($id)
    {
        $query = $this->db->get_where($this->_table, array('screen_id' => $id));
        return array('result'=>$query->result(),'success'=>1);
    }

    public function get_by_token($token)
    {
        $query = $this->db->get_where($this->_table, array('token' => $token));
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
        return $data;
    }
}
