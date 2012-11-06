<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/api_base.php";

class API extends API_Base {

	/**
	 * Get all the infoscreens owned by the authenticated customer
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function infoscreens_get() {
		if (!$this->input->get_request_header('Authorization')) {
			redirect('http://flatturtle.com');
		}
		$this->authorization->authorize(AUTH_ADMIN);

		try {
			$result = $this->infoscreen->get_by_customer_id($this->authorization->customer_id);
		} catch (ErrorException $e) {
			$this->_handleDatabaseException($e);
		}

		$this->output->set_output(json_encode($result));
	}

	/**
	 * Get a specific infoscreen owned by the authenticated customer
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function infoscreen_get($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$this->output->set_output(json_encode($infoscreen));
	}

	/**
	 * Change the details of the given infoscreen
	 * 
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function infoscreen_post($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$data = $this->input->post();
		if (empty($data)){
			$this->_throwError('404', ERROR_NO_PARAMETERS);
		}
		
		try {
			$this->infoscreen->update($infoscreen->id, $data);
		} catch (ErrorException $e) {
			$this->_throwError('403', $e->getMessage());
		}
	}
	
	/**
	 * Get all plugin states for a specific infoscreen owned by the authenticated customer
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function plugin_states_get($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);
		
		$data = $this->infoscreen->get_plugin_states($infoscreen->id);
		$this->output->set_output(json_encode($data));
	}

	/**
	 * Get all registered panes for the currently authenticated customer for a specific screen
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function panes_get($alias = false) {
		$this->authorization->authorize(array(AUTH_ADMIN));
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		if (!$alias)
			$alias = $this->authorization->alias;

		$this->load->model('pane');
		if (!$panes = $this->pane->get_by_infoscreen_id($infoscreen->id)) {
			$this->_throwError('404', ERROR_NO_TURTLES);
		}

		$this->output->set_output(json_encode($panes));
	}

	/**
	 * Add a pane for an infoscreen owned by the authenticated customer
	 * HTTP method: PUT
	 * Roles allowed: admin
	 */
	function panes_put($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$data = $this->extended_input->put();
		if (empty($data['type']))
			$this->_throwError('404', ERROR_NO_TYPE);

		unset($data['id']);
		$data['infoscreen_id'] = $infoscreen->id;
		$this->load->model('pane');
		try {
			$id = $this->pane->insert($data);
			$this->pane_get($alias, $id);
		} catch (ErrorException $e) {
			$this->_throwError('403', $e->getMessage());
		}
	}

	/**
	 * Get a specific pane owned by the authenticated customer
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function pane_get($alias, $id) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);
		
		$this->load->model('pane');
		if (!$pane = $this->pane->get($id))
			$this->_throwError('403', ERROR_NO_PANE);

		$this->output->set_output(json_encode($pane[0]));
	}

	/**
	 * Update a specific pane owned by the authenticated customer
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function pane_post($alias, $id) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$this->load->model('pane');
		if (!$pane = $this->pane->get($id))
			$this->_throwError('404', ERROR_NO_PANE);

		$data = $this->input->post();
		if (empty($data)){
			$this->_throwError('404', ERROR_NO_PARAMETERS);
		}
		
		try {
			$this->pane->update($id, $data);
		} catch (ErrorException $e) {
			$this->_throwError('403', $e->getMessage());
		}
	}

	/**
	 * Get all registered turtles for the currently authenticated customer for a specific screen
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function turtles_get($alias = false) {
		$this->authorization->authorize(array(AUTH_ADMIN, AUTH_MOBILE, AUTH_TABLET));
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		if (!$alias)
			$alias = $this->authorization->alias;

		$this->load->model('turtle');
		if (!$turtles = $this->turtle->get_by_infoscreen_id_with_options($infoscreen->id)) {
			$this->_throwError('404', ERROR_NO_TURTLES);
		}

		$this->output->set_output(json_encode($turtles));
	}

	/**
	 * Add a turtle for the currently authenticated customer for a specific screen
	 *
	 * HTTP method: PUT
	 * Roles allowed: admin
	 */
	function turtles_put($alias) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		$this->load->model('turtle');
		$this->load->model('turtle_option');
		$this->load->model('pane');
		$data = $this->extended_input->put();

		// Check turtle type
		if (empty($data['type']))
			$this->_throwError('404', ERROR_NO_TYPE);
		if (!$turtle_id = $this->turtle->get_id_of_type($data['type']))
			$this->_throwError('404', ERROR_NO_TURTLE_WITH_TYPE);

		// Check pane ID
		if (empty($data['pane']))
			$this->_throwError('404', ERROR_NO_PANE_PARAMETER);
		$pane = $this->pane->get($data['pane']);
		if (empty($pane[0]->id))
			$this->_throwError('404', ERROR_NO_PANE);

		$options = $data['options'];
		unset($data['options']);
		unset($data['type']);
		unset($data['pane']);		
		unset($data['id']);
		$data['turtle_id'] = $turtle_id;
		$data['pane_id'] = $pane[0]->id;
		$data['infoscreen_id'] = $infoscreen->id;
		try {
			$id = $this->turtle->insert($data);

			// Check options
			if (!empty($options)) {
				$options = json_decode($options);
				if ($options == null || !is_array($options))
					$this->_throwError('404', ERROR_OPTIONS_NO_JSON);

				foreach ($options as $option) {
					if (!empty($option->key) && !empty($option->value)) {
						$data = array();
						$data['key'] = $option->key;
						$data['value'] = $option->value;
						$data['turtle_instance_id'] = $id;
						$this->turtle_option->insert($data);
					}
				}
			}

			echo $this->turtle_get($alias, $id);
		} catch (ErrorException $e) {
			$this->_throwError('403', $e->getMessage());
		}
	}

	/**
	 * Get a specific turtle with turtle options registered to the currently authenticated customer
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function turtle_get($alias, $id) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);
		
		$this->load->model('turtle');
		if (!$turtle = $this->turtle->get_id_with_options($id))
			$this->_throwError('403', ERROR_NO_TURTLE_WITH_ID);

		$this->output->set_output(json_encode($turtle[0]));
	}

	/**
	 * Update turtle from a screen owned by the authenticated customer
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function turtle_post($alias, $id) {
		$this->authorization->authorize(AUTH_ADMIN);
		$infoscreen = parent::validate_and_get_infoscreen($alias);
		
		$this->load->model('turtle');
		if (!$result = $this->turtle->get($id))
			$this->_throwError('403', ERROR_NO_TURTLE_WITH_ID);

		$data = $this->input->post();
		$this->load->model('pane');
		$this->load->model('turtle_option');
		// Check pane ID
		unset($data['pane_id']);
		if (!empty($data['pane'])) {
			$pane = $this->pane->get($data['pane']);
			if (empty($pane[0]->id))
				$this->_throwError('404', ERROR_NO_PANE);
			else
				$data["pane_id"] = $pane[0]->id;
		}
		
		$options = $data['options'];
		unset($data['options']);
		unset($data['pane']);

		try {
			if(!empty($data))
				$this->turtle->update($id, $data);

			// Check options
			if (!empty($options)) {
				$options = json_decode($options);
				if ($options == null || !is_array($options))
					$this->_throwError('404', ERROR_OPTIONS_NO_JSON);

				foreach ($options as $option) {
					if (!empty($option->key)) {
						$data = array();
						$data['key'] = $option->key;
						$data['value'] = $option->value;
						$data['turtle_instance_id'] = $id;
						// Update, delete or insert option
						if($turtle_option = $this->turtle_option->get_by_key_for_turtle($data['key'],$id)){
							if(!empty($option->value))
								$this->turtle_option->update($turtle_option[0]->id,$data);
							else
								$this->turtle_option->delete($turtle_option[0]->id);
						}else{
							if(!empty($option->value))
								$this->turtle_option->insert($data);
						}
					}
				}
			}
		} catch (ErrorException $e) {
			$this->_throwError('403', $e->getMessage());
		}
	}

	/**
	 * Remove a turtle from a screen owned by the authenticated customer
	 *
	 * HTTP method: DELETE
	 * Roles allowed: admin
	 */
	function turtle_delete($alias, $id) {
		$this->authorization->authorize(AUTH_ADMIN);
	}

	/**
	 * Redirect to stable view
	 */
	function redirect_view($alias) {
		redirect(base_url() . $alias . '/view/stable');
	}

	/**
	 * Get all jobs for the currently authenticated customer for a specific screen
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function jobs_get($alias = false) {
		$this->authorization->authorize(array(AUTH_ADMIN, AUTH_MOBILE, AUTH_TABLET));
		$infoscreen = parent::validate_and_get_infoscreen($alias);

		if (!$alias)
			$alias = $this->authorization->alias;

		$this->load->model('jobtab');
		if (!$jobs = $this->jobtab->get_by_infoscreen_id($infoscreen->id)) {
			$this->_throwError('404', ERROR_NO_TURTLES);
		}

		$this->output->set_output(json_encode($jobs));
	}

	/**
	 * Export DISCS JSON 
	 */
	function export_json_get($alias) {
		try {
			$result = $this->infoscreen->get_by_alias($alias);
		} catch (ErrorException $e) {
			$this->_handleDatabaseException($e);
		}

		$this->output->set_header('Access-Control-Allow-Origin: *');
		$this->output->set_output($this->infoscreen->export_json($alias));
	}

}

?>