<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs, Michiel Vancoillie
 * Licence: AGPLv3
 */
class Screen extends MY_Controller
{

    /**
     * Authorizes a call to turn the screen on or off
     * Translates it to xmmp
     *
     * HTTP method: POST
     * POST vars: 'action' : 'on'
     * Roles allowed: admin
     */
    function power_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$action = $this->input->post('action'))
            $this->_throwError('400', ERROR_NO_ACTION_IN_POST);

        if($action == "off")
			$action = 'application.enableScreen(false)';
		else
			$action = 'application.enableScreen(true)';
			
		$infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, $action);
    }

    /**
     * Authorizes a call to reload the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    function reload_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        $infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "location.reload(true);");
    }
}
