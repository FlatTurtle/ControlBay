<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
require (APPPATH . '/libraries/rest.php');

class Screen extends REST_Controller
{
    function power_post($host){
        if(!$action = $this->input->post('action')){
            show_error("No action was given");
        }

        if($action == "on")
            $this->xmpp_lib->sendMessage($host, "application.enableScreen(true);");
        else
            $this->xmpp_lib->sendMessage($host, "application.enableScreen(false);");
    }

    function reload_post($host){
        $this->xmpp_lib->sendMessage($host, "location.reload(true);");
    }
}
