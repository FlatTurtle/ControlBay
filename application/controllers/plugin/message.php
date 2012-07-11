<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
require (APPPATH . '/libraries/rest.php');

class Message extends REST_Controller
{

    function add_post($host){
        if(!$message = $this->input->post('message')){
            show_error("No message was given");
        }

        $this->xmpp_lib->sendMessage($host, "Message.add('".$message."');");
    }

    function remove_post($host){
        $this->xmpp_lib->sendMessage($host, "Message.remove();");
    }
}
