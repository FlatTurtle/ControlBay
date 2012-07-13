<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Public_token extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table='public_tokens';
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

    static function getMobileExpiration(){
        $datetime = new DateTime();
        $interval = DateInterval::createFromDateString('10 minutes');
        $datetime = $datetime->add($interval);
        return $datetime->format('Y-m-d H:i:s');
    }

    static function getTabletExpiration(){
        return DateTime::createFromFormat('Y', '3000')->format('Y-m-d H:i:s');
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
