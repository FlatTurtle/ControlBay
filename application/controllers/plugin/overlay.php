<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Overlay extends Plugin_Base {

	private $type = 'overlay';

	/**
	 * Get status of the clock for an infoscreen
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	public function index_get($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		echo parent::get_state($alias, $this->type);
	}

	/**
	 * Display an image on the infoscreen
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	public function index_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		if (!$url = $this->input->post('url'))
			$this->_throwError('400', ERROR_NO_URL_IN_POST);

		if (!$timeout = $this->input->post('timeout'))
			$timeout = 0;

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Overlay.add('$url', $timeout);");
	}

	/**
	 * Remove the image from the infoscreen
	 *
	 * HTTP method: DELETE
	 * Roles allowed: admin
	 */
	public function index_delete($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Overlay.remove();");
	}

}

?>