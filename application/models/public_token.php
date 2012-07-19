<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
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
        return $query->result();
    }

    public function get_by_token($token)
    {
        $this->db->where('token', $token);
        $query = $this->db->get($this->_table);
            return $query->result();
    }

    /**
     * delete all expired tokens from the table
     *
     * @throws ErrorException when a database error occured
     */
    public function delete_expired(){
        $now = new DateTime();
        $this->db->where('expiration <', $now->format('Y-m-d H:i:s'));
        $this->db->delete($this->_table);
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
    }

    static function getMobileExpiration(){
        $datetime = new DateTime();
        $interval = DateInterval::createFromDateString('10 minutes');
        $datetime = $datetime->add($interval);
        return $datetime->format('Y-m-d H:i:s');
    }

    static function getTabletExpiration(){
        return DateTime::createFromFormat('Y', '9999')->format('Y-m-d H:i:s');
    }

    /**
     * Filter columns that are not allowed to be changed from row
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
