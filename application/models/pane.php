<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Pane extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'pane';
		$this->load->model('turtle_option');
    }
	

    public function get_by_infoscreen_id($screen_id)
    {
        $query = $this->db->get_where($this->_table, array('infoscreen_id' => $screen_id));
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
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
        unset($data['infoscreen_id']);
        return $data;
    }
}
