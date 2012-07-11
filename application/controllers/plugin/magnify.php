<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
require (APPPATH . '/libraries/rest.php');

class Magnify extends REST_Controller
{
    function turtle_post($host){
        if(!$turtle = $this->input->post('turtle')){
            show_error("No turtle id was given");
        }

        $this->xmpp_lib->sendMessage($host, "Magnify.turtle(".$turtle.");");
    }
}
