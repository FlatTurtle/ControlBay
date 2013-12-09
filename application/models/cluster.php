<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    require_once APPPATH . "models/rest_model.php";

class Cluster extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'cluster_infoscreen';
    }

    function get_by_infoscreen_id($id){
        $query = $this->db->where('x.infoscreen_id', $id);
        $this->db->join('cluster y','y.id = x.cluster_id','left');
        $query = $this->db->get($this->_table . ' x');
        return $query->result();
    }

    /**
     * Filter columns that are not allowed to be changed
     *
     * @param $data
     * @return mixed
     */
    function filter($data)
    {
        unset($data['cluster_id']);
        unset($data['infoscreen_id']);
        return $data;
    }
}
