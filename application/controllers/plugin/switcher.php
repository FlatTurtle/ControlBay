<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs, Michiel Vancoillie
 * Licence: AGPLv3
 */
class Switcher extends MY_Controller
{
    /**
     * Authorizes a call to switch to a certain turtle on the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    function focus_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$id = $this->input->post('turtle'))
            $this->_throwError('400', ERROR_NO_TURTLE_ID_IN_POST);

        $infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Switcher.turtle(" . $id . ");");
    }

    /**
     * Authorizes a call to rotate the turtle switcher
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    function rotate_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        $infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Switcher.rotate();");
    }

    /**
     * Authorizes a call to start the turtle switcher
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     * Url: example.com/plugin/switcher/start
     */
    function start_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        $infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Switcher.start();");
    }

    /**
     * Authorizes a call to stop the turtle switcher
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    function stop_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);

        $infoscreen = $this->infoscreen->get_by_alias($alias);
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->xmpp_lib->sendMessage($infoscreen[0]->hostname, "Switcher.stop();");
    }
}
