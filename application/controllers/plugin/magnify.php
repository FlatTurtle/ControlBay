<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs, Michiel Vancoillie
 * Licence: AGPLv3
 */
class Magnify extends MY_Controller
{
    /**
     * Authorizes a call to magnify a turtle on the infoscreen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * POST vars: 'turtle' : 'a turtle id'
     * Roles allowed: mobile, tablet, admin
     */
    function index_post($alias){
        $this->authorization->authorize(array(AUTH_MOBILE, AUTH_TABLET, AUTH_ADMIN));

        if(!$turtle = $this->input->post('turtle'))
            $this->_throwError('400', ERROR_NO_TURTLE_ID_IN_POST);

        if(!is_numeric($turtle))
            $this->_throwError('400', ERROR_TURTLE_ID_NOT_NUMERIC);
		
		$infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Magnify.turtle(".$turtle.");");
    }
}
