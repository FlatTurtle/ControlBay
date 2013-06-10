<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Jobtab extends REST_Model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'jobtab';
    }

    public function get_by_infoscreen_id($infoscreen_id)
    {
        $query = $this->db->where('x.infoscreen_id', $infoscreen_id);
        $this->db->join('job y','y.id = x.job_id','left');
        $query = $this->db->get($this->_table . ' x');
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
        unset($data['jobtab_id']);
        return $data;
    }
}
