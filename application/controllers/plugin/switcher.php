<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Switcher extends CI_Controller
{
    function focus($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if(!$id = $this->input->post('turtle')){
            show_error("No turtle id was given");
        }

        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Switcher.turtle(" . $$id . ");");
        }
    }

    function rotate($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Switcher.rotate();");
        }
    }

    function start($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Switcher.start();");
        }
    }

    function stop($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Switcher.stop();");
        }
    }
}
