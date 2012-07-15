<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Overlay extends MY_Controller
{

    function add_post(){
        if(!$url = $this->input->post('url')){
            $this->output->set_response_header('400');
        }

        if(!$timeout = $this->input->post('timeout')){
            $timeout = 0;
        }

        $this->xmpp_lib->sendMessage($this->host, "Overlay.add('$url', $timeout);");
    }

    function remove_post(){
        $this->xmpp_lib->sendMessage($this->host, "Overlay.remove();");
    }
}
