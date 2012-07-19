<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Clock extends MY_Controller
{

    function add_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Clock.add();");
    }

    function remove_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Clock.remove();");
    }
}
