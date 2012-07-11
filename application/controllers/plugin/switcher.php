<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
require (APPPATH . '/libraries/rest.php');

class Switcher extends REST_Controller
{
    function focus_post($host){
        if(!$id = $this->input->post('turtle')){
            show_error("No turtle id was given");
        }

        $this->xmpp_lib->sendMessage($host, "Switcher.turtle(" . $$id . ");");
    }

    function rotate_post($host){
        $this->xmpp_lib->sendMessage($host, "Switcher.rotate();");
    }

    function start_post($host){
        $this->xmpp_lib->sendMessage($host, "Switcher.start();");
    }

    function stop_post($host){
        $this->xmpp_lib->sendMessage($host, "Switcher.stop();");
    }
}
