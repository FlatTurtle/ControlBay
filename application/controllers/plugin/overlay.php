<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs, Michiel Vancoillie
 * Licence: AGPLv3
 */
class Overlay extends MY_Controller
{
    /**
     * Authorizes a call to display an image on the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * POST vars: 'url' : 'some image url'
     * Roles allowed: admin
     */
    function index_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$url = $this->input->post('url'))
            $this->_throwError('400', ERROR_NO_URL_IN_POST);

        if(!$timeout = $this->input->post('timeout'))
            $timeout = 0;
		
		$infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Overlay.add('$url', $timeout);");
    }

    /**
     * Authorizes a call to remove an image from the screen
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

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Overlay.remove();");
    }
}
