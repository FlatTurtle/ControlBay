<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs, Michiel Vancoillie
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
     */
    function index_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$message = $this->input->post('message'))
            $this->_throwError('400', ERROR_NO_MESSAGE_IN_POST);
		
		$infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Message.add('".$message."');");
    }

    /**
     * Authorizes a call to remove a message from the screen
     * Translates it to xmmp
     *
     * HTTP method: DELETE
     * Roles allowed: admin
     */
    function index_delete($alias){
        $this->authorization->authorize(AUTH_ADMIN);		
		$infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);
		
        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Message.remove();");
    }
}
