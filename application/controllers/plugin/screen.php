<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Screen extends MY_Controller
{
    function power_post(){
        if(!$action = $this->input->post('action')){
            $this->output->set_response_header('400');
        }

        if($action == "on")
            $this->xmpp_lib->sendMessage($this->host, "application.enableScreen(true);");
        else
            $this->xmpp_lib->sendMessage($this->host, "application.enableScreen(false);");
    }

    function reload_post(){
        $this->xmpp_lib->sendMessage($this->host, "location.reload(true);");
    }
}
