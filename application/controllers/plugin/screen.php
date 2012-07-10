<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Screen
{
    function power($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if(!$action = $this->input->post('action')){
            show_error("No action was given");
        }

        if($method == "POST"){
            if($action == "on")
                $this->xmpp_lib->sendMessage($host, "application.enableScreen(true);");
            else
                $this->xmpp_lib->sendMessage($host, "application.enableScreen(false);");
        }
    }

    function reload($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "location.reload(true);");
        }
    }
}
