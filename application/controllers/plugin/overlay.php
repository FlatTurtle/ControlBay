<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Overlay extends MY_Controller
{
    function add_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        if(!$url = $this->input->post('url')){
            $this->output->set_response_header('400');
        }

        if(!$timeout = $this->input->post('timeout')){
            $timeout = 0;
        }

        $this->xmpp_lib->sendMessage($this->_host, "Overlay.add('$url', $timeout);");
    }

    function remove_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->_host, "Overlay.remove();");
    }
}
