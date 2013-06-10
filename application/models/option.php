<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Option extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table = 'option';
    }

    public function get_by_name($name){
        $this->db->where('name', $name);
        $query = $this->db->get($this->_table);
        if($query->num_rows() > 1){
            $data = array();
            foreach($query->result() as $row){
                $value_decoded = json_decode($row->value);
                if(json_last_error() == JSON_ERROR_NONE){
                    $row->value = $value_decoded;
                }
                array_push($data, $row->value);
            }
            return $data;
        }else if($query->num_rows() == 1){
            $row = $query->result();
            $value_decoded = json_decode($row->value);
            if(json_last_error() == JSON_ERROR_NONE){
                $row->value = $value_decoded;
            }
            return $row->value;
        }else{
            return null;
        }
    }

    /**
     * Filter columns that are not allowed to be changed from row
     */
    function filter($data)
    {
        unset($data['id']);
        return $data;
    }
}