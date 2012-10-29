<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Message extends MY_Controller
{
    /**
     * Authorizes a call to display a message on the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * POST vars: 'message' : 'some message'
     * Roles allowed: admin
     * Url: example.com/plugin/message/add
     */
    function add_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$message = $this->input->post('message'))
            $this->_throwError('400', ERROR_NO_MESSAGE_IN_POST);
		
        if(!$host = $this->input->post('host'))
            $this->_throwError('400', "No hostname given");

        $this->xmpp_lib->sendMessage($host, "Message.add('".$message."');");
    }

    /**
     * Authorizes a call to remove a message from the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    function remove_post(){
        $this->authorization->authorize($this->authorization->host, AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->_host, "Message.remove();");
    }
}
