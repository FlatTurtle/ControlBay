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

        $this->xmpp_lib->sendMessage($host, "Overlay.add('".$url."');");
    }

    function remove_post($host){
        $this->xmpp_lib->sendMessage($host, "Overlay.remove();");
    }
}
