<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Overlay extends MY_Controller
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
