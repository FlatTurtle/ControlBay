<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Message extends Plugin_Base {

	/**
	 * Display a message on the screen
	 *
	 * HTTP method: POST
	 * POST vars: 'message' : 'some message'
	 * Roles allowed: admin
	 */
	function index_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		if (!$message = $this->input->post('message'))
			$this->_throwError('400', ERROR_NO_MESSAGE_IN_POST);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Message.add('" . $message . "');");
	}

	/**
	 * Remove the message from the screen
	 *
	 * HTTP method: DELETE
	 * Roles allowed: admin
	 */
	function index_delete($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Message.remove();");
	}

}

?>