<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
class Plugin_Base extends MY_Controller {

	/**
	 * Validate a request and return infoscreen from alias
	 */
	private function _validate_request($alias) {
		if (!$infoscreen = $this->infoscreen->get_by_alias($alias))
			$this->_throwError('404', ERROR_NO_INFOSCREEN);

		// Check ownership
		if (!$this->infoscreen->isOwner($alias))
			$this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

		return $infoscreen[0];
	}

	/**
	 * Get plugin state
	 */
	protected function get_state($alias, $type) {
		$infoscreen = $this->_validate_request($alias);

		return json_encode($this->infoscreen->get_plugin_state($infoscreen->id, $type));
	}

	/**
	 * Validate request and get infoscreen
	 */
	protected function validate_and_get_infoscreen($alias) {
		return $this->_validate_request($alias);
	}

}

?>