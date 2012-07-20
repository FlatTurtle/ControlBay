<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Switcher extends MY_Controller
{
    /**
     * Authorizes a call to switch to a certain turtle on the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     * Url: example.com/plugin/switcher/focus
     */
    function focus_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$id = $this->input->post('turtle'))
            $this->_throwError('400', ERROR_NO_TURTLE_ID_IN_POST);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Switcher.turtle(" . $$id . ");");
    }

    /**
     * Authorizes a call to rotate the turtle switcher
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     * Url: example.com/plugin/switcher/rotate
     */
    function rotate_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Switcher.rotate();");
    }

    /**
     * Authorizes a call to start the turtle switcher
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     * Url: example.com/plugin/switcher/start
     */
    function start_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Switcher.start();");
    }

    /**
     * Authorizes a call to stop the turtle switcher
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     * Url: example.com/plugin/switcher/stop
     */
    function stop_post($host){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($host, "Switcher.stop();");
    }
}
