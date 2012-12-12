<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Route extends Plugin_Base {

	/**
	 * Display a fullscreen turtle for the requested NMBS route
	 */
	function nmbs_post($alias) {
        $infoscreen = parent::validate_and_get_infoscreen(array(AUTH_ADMIN, AUTH_TABLET), $alias);

		if (!$from = $this->input->post('from'))
			$this->_throwError('400', ERROR_MISSING_PARAMETER);

		if (!$to = $this->input->post('to'))
			$this->_throwError('400', ERROR_MISSING_PARAMETER);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Message.enable('" . $from . " - " . $to . "');");
	}

}

?>