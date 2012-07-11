<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
require (APPPATH . '/libraries/rest.php');

class Browser extends REST_Controller
{
    function browse_post($host){
        if(!$url = $this->input->post('url')){
            show_error("No url was given");
        }

        $this->xmpp_lib->sendMessage($host, "Browser.go('" . $url . "');");
    }
}
