<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Browser extends MY_Controller
{

    function browse_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        if(!$url = $this->input->post('url')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->_host, "Browser.go('" . $url . "');");
    }
}
