<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Message extends MY_Controller
{
    function add_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        if(!$message = $this->input->post('message')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->_host, "Message.add('".$message."');");
    }

    function remove_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->_host, "Message.remove();");
    }
}
