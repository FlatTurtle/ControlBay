<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Screen extends MY_Controller
{
    const ERROR_NO_ACTION = "No action specified in the POST body";

    function power_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$action = $this->input->post('action'))
            $this->_throwError('400', self::ERROR_NO_ACTION);

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
