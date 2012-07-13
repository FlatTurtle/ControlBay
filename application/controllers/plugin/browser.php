<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Browser extends MY_Controller
{
    function browse_post($host){
        if(!$url = $this->input->post('url')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($host, "Browser.go('" . $url . "');");
    }
}
