<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Message extends MY_Controller
{
    const ERROR_NO_MESSAGE_IN_POST = "No message given in POST body";

    function add_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        if(!$message = $this->input->post('message'))
            $this->_throwError('400', self::ERROR_NO_MESSAGE_IN_POST);

        $this->xmpp_lib->sendMessage($this->_host, "Message.add('".$message."');");
    }

    function remove_post(){
        $this->authorization->authorize($this->_role, AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->_host, "Message.remove();");
    }
}
