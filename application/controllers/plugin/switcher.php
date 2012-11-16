<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Switcher extends Plugin_Base {

	/**
	 * Switch to a certain pane on the screen
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function focus_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		if (!$pane = $this->input->post('pane'))
			$this->_throwError('400', ERROR_NO_PANE_PARAMETER);

		if (!is_numeric($pane))
			$this->_throwError('400', ERROR_PANE_ID_NOT_NUMERIC);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Panes.show(" . $pane . ");");
	}

	/**
	 * Rotate the pane switcher
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function rotate_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);
		
		if (!$type = $this->input->post('type'))
			$this->_throwError('400', ERROR_NO_PARAMETERS);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Panes.rotate(" . $type . ");");
	}

}

?>