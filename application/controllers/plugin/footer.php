<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Footer extends Plugin_Base {

	private $type = 'footer';

	/**
	 * Get value of footer
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	public function index_get($alias){
		echo parent::get_state($alias, $this->type);
	}

	/**
	 * Enable footer on screen
	 *
	 * HTTP method: POST
	 * POST vars: 'value' : 'some text/RSS link'
	 * Roles allowed: admin
	 */
	function index_post($alias) {
        $infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		if (!$value = $this->input->post('value'))
			$this->_throwError('400', ERROR_NO_PARAMETERS);

		$this->infoscreen->set_plugin_state($infoscreen->id, $this->type, $value);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Footer.enable('" . $value . "');");
	}

	/**
	 * Remove the footer from the screen
	 *
	 * HTTP method: DELETE
	 * Roles allowed: admin
	 */
	function index_delete($alias) {
        $infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);
		$this->infoscreen->disable_plugin($infoscreen->id, $this->type);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Footer.disable();");
	}

}

?>