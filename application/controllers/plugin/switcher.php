<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Switcher extends Plugin_Base {

	/**
	 * Switch to a certain turtle on the screen
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function focus_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		if (!$turtle = $this->input->post('turtle'))
			$this->_throwError('400', ERROR_NO_TURTLE_ID_IN_POST);

		if (!is_numeric($turtle))
			$this->_throwError('400', ERROR_TURTLE_ID_NOT_NUMERIC);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Switcher.turtle(" . $turtle . ");");
	}

	/**
	 * Rotate the turtle switcher
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function rotate_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Switcher.rotate();");
	}

	/**
	 * Start the turtle switcher
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function start_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Switcher.start();");
	}

	/**
	 * Stop the turtle switcher
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function stop_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Switcher.stop();");
	}

}

?>