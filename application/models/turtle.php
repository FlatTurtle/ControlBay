<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Turtle extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'turtle_link';
    }


    public function get_by_screen_id_with_options($screen_id)
    {
        $this->db->where('x.infoscreen_id', $screen_id);
        $this->db->join('turtle y', 'x.turtle_id = y.id', 'left');
        $this->db->join('turtle_option z', 'x.turtle_option_id = z.id', 'left');
        $query = $this->db->get($this->_table . ' x');
        if($this->db->_error_number())
            throw new ErrorException($this->db->_error_message());
        return $query->result();
    }

    public function get_by_screen_id($screen_id)
    {
        $this->db->join('turtle y', 'x.turtle_id = y.id', 'left');
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
        unset($data['turtle_id']);
        unset($data['turtle_option_id']);
        unset($data['infoscreen_id']);
        unset($data['module']);
        return $data;
    }
}
