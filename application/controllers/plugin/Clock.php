<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Clock extends CI_Controller
{

    function add($host){
        $this->load->library('xmpp');
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            $this->xmpp->sendMessage($host, "Clock.add();");
        }
    }

    function remove($host){
        $this->load->library('xmpp');
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            $this->xmpp->sendMessage($host, "Clock.remove();");
        }
    }
}
