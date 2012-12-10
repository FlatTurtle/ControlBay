<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Browser extends Plugin_Base {

	/**
	 * Display another URL on the infoscreen
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function browse_post($alias) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		if (!$url = $this->input->post('url'))
			$this->_throwError('400', ERROR_NO_URL_IN_POST);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "location='" . $url . "';");
	}

}

?>