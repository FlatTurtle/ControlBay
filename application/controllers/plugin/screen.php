<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Screen extends Plugin_Base {

	private $type = 'power';
	/**
	 * Get the status of the screen
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function power_get($alias) {
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
        $infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		if (!$action = $this->input->post('action'))
			$this->_throwError('400', ERROR_NO_ACTION_IN_POST);

		if ($action == "off"){
			$this->infoscreen->disable_plugin($infoscreen->id, $this->type);
			$action = 'Power.disable();';
		}else{
			$this->infoscreen->set_plugin_state($infoscreen->id, $this->type, 1);
			$action = 'Power.enable();';
		}

		$this->xmpp_lib->sendMessage($infoscreen->hostname, $action);
	}

	/**
	 * Reload the screen
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function reload_post($alias) {
        $infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "location.reload(true);");
	}

}

?>