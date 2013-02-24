<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class User_token extends REST_Model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'user_token';
    }


    public function get_by_token($token)
    {
        $query = $this->db->get_where($this->_table, array('token' => $token));
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
        unset($data['id']);
        return $data;
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

    public static function getUserExpiration()
    {
        $datetime = new DateTime();
        $interval = DateInterval::createFromDateString('60 minutes');
        $datetime = $datetime->add($interval);
        return $datetime->format('Y-m-d H:i:s');
    }
}
