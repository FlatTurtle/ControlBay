<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Job extends REST_Model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'jobs';
    }


    public function get_by_id($id)
    {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->result();
    }

    public function get_by_jobname($jobname)
    {
        $query = $this->db->get_where($this->table, array('jobname' => $jobname));
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
}
