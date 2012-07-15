<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Message extends MY_Controller
{

    function add_post(){
        if(!$message = $this->input->post('message')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->host, "Message.add('".$message."');");
    }

    function remove_post(){
        $this->xmpp_lib->sendMessage($this->host, "Message.remove();");
    }
}
