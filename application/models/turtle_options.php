<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Turtle_options extends REST_model
{
    var $table = 'turtle_options';

    /**
     * Filter primary keys from row
     *
     * @param $data
     * @return mixed
     */
    function filter($data)
    {
        unset($data['turtle_id']);
        unset($data['key']);
        return $data;
    }
}
