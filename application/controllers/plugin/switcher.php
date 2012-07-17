<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Switcher extends MY_Controller
{
    function focus_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        if(!$id = $this->input->post('turtle')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->_host, "Switcher.turtle(" . $$id . ");");
    }

    function rotate_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->_host, "Switcher.rotate();");
    }

    function start_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->_host, "Switcher.start();");
    }

    function stop_post($host){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($host, "Switcher.stop();");
    }
}
