<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Clock extends MY_Controller
{

    function add_post($host){
            $this->xmpp_lib->sendMessage($host, "Clock.add();");
    }

    function remove_post($host){
            $this->xmpp_lib->sendMessage($host, "Clock.remove();");
    }
}
