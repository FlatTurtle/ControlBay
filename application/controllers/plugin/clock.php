<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Clock extends MY_Controller
{

    /**
     * Authorizes a call to add a clock to the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     * Url: example.com/plugin/clock/add
     */
    function add_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Clock.add();");
    }

    /**
     * Authorizes a call to remove a clock from the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     * Url: example.com/plugin/clock/remove
     */
    function remove_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Clock.remove();");
    }
}
