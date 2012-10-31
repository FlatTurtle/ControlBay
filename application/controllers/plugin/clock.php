<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs, Michiel Vancoillie
 * Licence: AGPLv3
 */
class Clock extends MY_Controller
{

    /**
     * Authorizes a call to add a clock to the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    function index_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        $infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Clock.add();");
    }

    /**
     * Authorizes a call to remove a clock from the screen
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

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Clock.remove();");
    }
}
