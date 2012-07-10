<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Clock extends CI_Controller
{

    function add($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Clock.add();");
        }
    }

    function remove($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Clock.remove();");
        }
    }
}
