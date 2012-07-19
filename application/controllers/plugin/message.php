<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Message extends MY_Controller
{
    function add_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$message = $this->input->post('message'))
            $this->_throwError('400', ERROR_NO_MESSAGE_IN_POST);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Message.add('".$message."');");
    }

    function remove_post(){
        $this->authorization->authorize($this->authorization->host, AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->_host, "Message.remove();");
    }
}
