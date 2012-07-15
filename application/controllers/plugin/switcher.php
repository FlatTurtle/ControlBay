<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Switcher extends MY_Controller
{
    function focus_post(){
        if(!$id = $this->input->post('turtle')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->host, "Switcher.turtle(" . $$id . ");");
    }

    function rotate_post(){
        $this->xmpp_lib->sendMessage($this->host, "Switcher.rotate();");
    }

    function start_post(){
        $this->xmpp_lib->sendMessage($this->host, "Switcher.start();");
    }

    function stop_post($host){
        $this->xmpp_lib->sendMessage($host, "Switcher.stop();");
    }
}
