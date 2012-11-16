<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Clock extends Plugin_Base{
	
	private $type = 'clock';
	
	/**
     * Get status of the clock for an infoscreen
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    public function index_get($alias){
        $this->authorization->authorize(AUTH_ADMIN);
		echo parent::get_state($alias, $this->type);
    }

    /**
     * Add the clock to the infoscreen
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    public function index_post($alias){
        $this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);
		
        $this->xmpp_lib->sendMessage($infoscreen->hostname, "Clock.enable();");
    }

    /**
     * Remove the clock from the infoscreen
     *
     * HTTP method: DELETE
     * Roles allowed: admin
     */
    public function index_delete($alias){
        $this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

        $this->xmpp_lib->sendMessage($infoscreen->hostname, "Clock.disable();");
    }
}
