<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Magnify extends CI_Controller
{
    function turtle($host, $turtle){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            sendMessage($host, "Magnify.turtle(".$turtle.");");
        }
    }
}
