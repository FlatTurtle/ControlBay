<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Screen extends MY_Controller
{
    function power_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$action = $this->input->post('action'))
            $this->_throwError('400', ERROR_NO_ACTION_IN_POST);

        if($action == "on")
            $this->xmpp_lib->sendMessage($this->authorization->host, "application.enableScreen(true);");
        else
            $this->xmpp_lib->sendMessage($this->authorization->host, "application.enableScreen(false);");
    }

    function reload_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "location.reload(true);");
    }
}
