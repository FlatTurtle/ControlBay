<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Message extends MY_Controller
{

    function add_post($host){
        if(!$message = $this->input->post('message')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($host, "Message.add('".$message."');");
    }

    function remove_post($host){
        $this->xmpp_lib->sendMessage($host, "Message.remove();");
    }
}
