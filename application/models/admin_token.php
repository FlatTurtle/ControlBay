<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Admin_token extends REST_Model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'admin_tokens';
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
        // TODO: Implement filter() method.
    }

    public static function getAdminExpiration()
    {
        $datetime = new DateTime();
        $interval = DateInterval::createFromDateString('60 minutes');
        $datetime = $datetime->add($interval);
        return $datetime->format('Y-m-d H:i:s');
    }
}
