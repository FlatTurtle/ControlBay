<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs, Michiel Vancoillie
 * Licence: AGPLv3
 */
class Browser extends MY_Controller
{

    /**
     * Authorizes a client call to display another website on the infoscreen
     * Translates the call to an xmpp message
     *
     * HTTP method: POST
     * POST vars: 'url': 'a url'
     * Roles allowed: admin
     */
    function browse_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$url = $this->input->post('url'))
            $this->_throwError('400', ERROR_NO_URL_IN_POST);
		
		$infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "location='" . $url . "';");
    }
}
