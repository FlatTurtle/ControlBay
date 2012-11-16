<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Screen extends Plugin_Base {

	private $type = 'screen';
	/**
	 * Get the status of the screen
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function power_get($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		echo parent::get_state($alias, $this->type);
	}
	
	/**
	 * Turn the screen on or off
	 *
	 * HTTP method: POST
	 * POST vars: 'action' : 'on'
	 * Roles allowed: admin
	 */
	function power_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		if (!$action = $this->input->post('action'))
			$this->_throwError('400', ERROR_NO_ACTION_IN_POST);

		if ($action == "off")
			$action = 'Power.disable();';
		else
			$action = 'Power.enable();';

		$this->xmpp_lib->sendMessage($infoscreen->hostname, $action);
	}

	/**
	 * Reload the screen
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function reload_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "location.reload(true);");
	}

}

?>