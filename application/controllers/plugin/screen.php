<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Screen extends MY_Controller
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
