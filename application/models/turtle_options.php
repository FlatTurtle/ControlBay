<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . "models/rest_model.php";
class Turtle_options extends REST_model
{
    function __construct()
    {
        parent::__construct();
        $this->_table('turtle_option');
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
        unset($data['key']);
        return $data;
    }
}
