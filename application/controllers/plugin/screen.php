<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Screen extends MY_Controller
{

    /**
     * Authorizes a call to turn the screen on or off
     * Translates it to xmmp
     *
     * HTTP method: POST
     * POST vars: 'action' : 'on'
     * Roles allowed: admin
     * Url: example.com/plugin/screen/power
     */
    function power_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$action = $this->input->post('action'))
            $this->_throwError('400', ERROR_NO_ACTION_IN_POST);

        if($action == "on")
            $this->xmpp_lib->sendMessage($this->authorization->host, "application.enableScreen(true);");
        else
            $this->xmpp_lib->sendMessage($this->authorization->host, "application.enableScreen(false);");
    }

    /**
     * Authorizes a call to reload the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     * Url: example.com/plugin/screen/reload
     */
    function reload_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "location.reload(true);");
    }
}
