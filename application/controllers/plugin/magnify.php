<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Magnify extends CI_Controller
{
    function turtle($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if(!$turtle = $this->input->post('turtle')){
            show_error("No turtle id was given");
        }


        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Magnify.turtle(".$turtle.");");
        }
    }
}
