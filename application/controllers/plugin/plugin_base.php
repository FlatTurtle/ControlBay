<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/api_base.php";

class Plugin_Base extends API_Base {

	/**
	 * Get plugin state
	 */
	protected function get_state($alias, $type) {
        $infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		return json_encode($this->infoscreen->get_plugin_state($infoscreen->id, $type));
	}

}

?>