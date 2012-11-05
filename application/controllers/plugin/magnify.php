<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Magnify extends Plugin_Base {

	/**
	 * Magnify a turtle on the infoscreen
	 *
	 * HTTP method: POST
	 * POST vars: 'turtle' : 'a turtle id'
	 * Roles allowed: mobile, tablet, admin
	 */
	function index_post($alias) {
		$this->authorization->authorize(array(AUTH_MOBILE, AUTH_TABLET, AUTH_ADMIN));
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		if (!$turtle = $this->input->post('turtle'))
			$this->_throwError('400', ERROR_NO_TURTLE_ID_IN_POST);

		if (!is_numeric($turtle))
			$this->_throwError('400', ERROR_TURTLE_ID_NOT_NUMERIC);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Magnify.turtle(" . $turtle . ");");
	}

}

?>