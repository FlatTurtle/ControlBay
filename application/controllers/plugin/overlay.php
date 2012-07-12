<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
require (APPPATH . '/libraries/rest.php');

class Overlay extends REST_Controller
{

    function add_post($host){
        if(!$url = $this->input->post('url')){
            show_error("No url was given");
        }

        if(!$timeout = $this->input->post('timeout')){
            $timeout = 0;
        }

        $this->xmpp_lib->sendMessage($host, "Overlay.add('$url', $timeout);");
    }

    function remove_post($host){
        $this->xmpp_lib->sendMessage($host, "Overlay.remove();");
    }
}
