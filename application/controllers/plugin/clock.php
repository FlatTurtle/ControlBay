<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
require (APPPATH . '/libraries/rest.php');

class Clock extends REST_Controller
{

    function add_post($host){
            $this->xmpp_lib->sendMessage($host, "Clock.add();");
    }

    function remove_post($host){
            $this->xmpp_lib->sendMessage($host, "Clock.remove();");
    }
}
