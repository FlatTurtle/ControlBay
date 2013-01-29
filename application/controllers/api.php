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
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$this->output->set_output(json_encode($infoscreen));
	}

	/**
	 * Change the details of the given infoscreen
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function infoscreen_post($alias) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$data = $this->input->post();
		if (empty($data)){
			$this->_throwError('400', ERROR_NO_PARAMETERS);
		}

		$message = "";

		if(!empty($data['location'])){
			$options = new stdClass();
			$options->location = $data['location'];
			$options->longitude = $data['longitude'];
			$options->latitude = $data['latitude'];
			$message .= "Screen.update(".json_encode($options).");";
		}

		if(!empty($data['color'])){
			$message .= "Interface.color('" . $data['color'] . "');";
		}

		if(!empty($data['logo'])){
			$message .= "Interface.logo('" . $data['logo'] . "?".  rand(0, 9999)."');";
		}

		if(!empty($message)){
			$this->xmpp_lib->sendMessage($infoscreen->hostname, $message);
		}

		try {
			$this->infoscreen->update($infoscreen->id, $data);
		} catch (ErrorException $e) {
			$this->_throwError('500', $e->getMessage());
		}
	}

	/**
	 * Get a certain option
	 * HTTP method: GET
	 */
	function option_get() {
		$this->load->model('option');
		$name = $this->input->get("name");
		if (empty($name)){
			$this->_throwError('400', ERROR_NO_PARAMETERS);
		}

		$data = $this->option->get_by_name($name);
		$this->output->set_output(json_encode($data));
	}

	/**
	 * Get all available turtles with the available options
	 * HTTP method: GET
	 */
	function list_turtles() {
		$this->load->model('turtle');
		$data = $this->turtle->get_all_turtles();
		$this->output->set_output(json_encode($data));
	}

	/**
	 * Get all plugin states for a specific infoscreen owned by the authenticated customer
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function plugin_states_get($alias) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

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
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		if (!$alias)
			$alias = $this->authorization->alias;

		$this->load->model('pane');
		if($this->input->get('type')){
			if (!$panes = $this->pane->get_by_type($infoscreen->id, $this->input->get('type'))) {
				$this->_throwError('404', ERROR_NO_PANES_TYPE);
			}
		}elseif(!$panes = $this->pane->get_by_infoscreen_id($infoscreen->id)) {
			$this->_throwError('404', ERROR_NO_PANES);
		}

		$this->output->set_output(json_encode($panes));
	}

	/**
	 * Add a pane for an infoscreen owned by the authenticated customer
	 * HTTP method: PUT
	 * Roles allowed: admin
	 */
	function panes_put($alias) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$data = $this->extended_input->put();
		if (empty($data['type']))
			$this->_throwError('400', ERROR_NO_TYPE);

		$turtles = "";
		try{
			$turtles = json_decode($data['turtles']);
		}catch(ErrorException $e){}
		unset($data['id']);
		unset($data['turtles']);
		$data['infoscreen_id'] = $infoscreen->id;

		$this->load->model('pane');
		try {
			$id = $this->pane->insert($data);
			$data['duration'] = 15000;
			$data['order'] = 0;
			$pane_data = json_encode($data);
			$message .= "Panes.add('$id',".$pane_data.");";

			// Add turtles when given
			if($turtles){
				$this->load->model('turtle');

				foreach($turtles as $turtle){
					$turtle->type;

					// Check turtle type
					if (!empty($turtle->type)){
						$turtle_type = $turtle->type;

						if ($turtle_id = $this->turtle->get_id_of_type($turtle_type)){
							$data = array();
							$data['turtle_id'] = $turtle_id;
							$data['pane_id'] = $id;
							$data['infoscreen_id'] = $infoscreen->id;
							$data['order'] = $turtle->order;
							if(!is_numeric($data['order']))
								$data['order'] = 0;

							try {
								$id = $this->turtle->insert($data);
								// Add it with empty options
								$message .= "Turtles.grow('".$turtle_type."'," . $turtle_id . ", ".$id.", 0, {});";
							}catch(ErrorException $e){

							}
						}

					}
				}
			}

			// Add everything live
			$this->xmpp_lib->sendMessage($infoscreen->hostname, $message);

			$this->pane_get($alias, $id);
		} catch (ErrorException $e) {
			$this->_throwError('500', $e->getMessage());
		}
	}

	/**
	 * Get a specific pane owned by the authenticated customer
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function pane_get($alias, $id) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$this->load->model('pane');
		if (!$pane = $this->pane->get($id))
			$this->_throwError('404', ERROR_NO_PANE);

		$this->output->set_output(json_encode($pane[0]));
	}

	/**
	 * Update a specific pane owned by the authenticated customer
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function pane_post($alias, $id) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$data = $this->input->post();
		if (empty($data)){
			$this->_throwError('400', ERROR_NO_PARAMETERS);
		}

		$this->load->model('pane');
		if (!$pane = $this->pane->get($id))
			$this->_throwError('404', ERROR_NO_PANE);

		try {
			$this->pane->update($id, $data);
			$this->xmpp_lib->sendMessage($infoscreen->hostname, "Panes.options(". $id . ", ". json_encode($data) .");");
		} catch (ErrorException $e) {
			$this->_throwError('500', $e->getMessage());
		}
	}

	/**
	 * Delete a specific pane owned by the authenticated customer
	 * Roles allowed: admin
	 */
	function pane_delete($alias, $id) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$this->load->model('pane');
		if (!$pane = $this->pane->get($id))
			$this->_throwError('404', ERROR_NO_PANE);

		$this->pane->delete($id);


		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Panes.remove(". $id . ");");
	}

	/**
	 * Get all registered turtles for the currently authenticated customer for a specific screen
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function turtles_get($alias = false) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		if (!$alias)
			$alias = $this->authorization->alias;

		$this->load->model('turtle');
		if($this->input->get('pane_type')){
			if (!$turtles = $this->turtle->get_by_pane_type_with_options($infoscreen->id, $this->input->get('pane_type'))) {
				$this->_throwError('404', ERROR_NO_TURTLES_PANE_TYPE);
			}
		}else{
			if (!$turtles = $this->turtle->get_by_infoscreen_id_with_options($infoscreen->id)) {
				$this->_throwError('404', ERROR_NO_TURTLES);
			}
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
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$this->load->model('turtle');
		$this->load->model('turtle_option');
		$this->load->model('pane');
		$data = $this->extended_input->put();

		// Check turtle type
		if (empty($data['type']))
			$this->_throwError('400', ERROR_NO_TYPE);
		if (!$turtle_id = $this->turtle->get_id_of_type($data['type']))
			$this->_throwError('404', ERROR_NO_TURTLE_WITH_TYPE);

		// Check pane ID
		if (empty($data['pane']))
			$this->_throwError('400', ERROR_NO_PANE_PARAMETER);
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
				if ($options == null || !is_object($options))
					$this->_throwError('400', ERROR_OPTIONS_NO_JSON);

				foreach ($options as $key => $value) {
					if (!empty($key) && !empty($value)) {
						$data = array();
						$data['key'] = $key;
						$data['value'] = $value;
						$data['turtle_instance_id'] = $id;
						$this->turtle_option->insert($data);
					}
				}
			}

			$turtle = $this->turtle->get_id_with_options($id);
			$this->xmpp_lib->sendMessage($infoscreen->hostname, "Turtles.grow('".$turtle[0]->type."'," . $id . ", ".$turtle[0]->pane_id.", 0,". json_encode($turtle[0]->options) .");");

			$this->output->set_output(json_encode($turtle[0]));
			//echo $turtle_json;
		} catch (ErrorException $e) {
			$this->_throwError('500', $e->getMessage());
		}
	}

	/**
	 * Get a specific turtle with turtle options registered to the currently authenticated customer
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function turtle_get($alias, $id) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$this->load->model('turtle');
		if (!$turtle = $this->turtle->get_id_with_options($id))
			$this->_throwError('404', ERROR_NO_TURTLE_WITH_ID);

		$this->output->set_output(json_encode($turtle[0]));
	}

	/**
	 * Update turtle from a screen owned by the authenticated customer
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function turtle_post($alias, $id) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$this->load->model('turtle');
		if (!$result = $this->turtle->get($id))
			$this->_throwError('404', ERROR_NO_TURTLE_WITH_ID);

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
				if ($options == null || !is_object($options))
					$this->_throwError('400', ERROR_OPTIONS_NO_JSON);

				foreach ($options as $key => $value) {
					if (!empty($key)) {
						$data = array();
						$data['key'] = $key;
						$data['value'] = $value;
						$data['turtle_instance_id'] = $id;
						// Update, delete or insert option
						if($turtle_option = $this->turtle_option->get_by_key_for_turtle($data['key'],$id)){
							if(!empty($value))
								$this->turtle_option->update($turtle_option[0]->id,$data);
							else
								$this->turtle_option->delete($turtle_option[0]->id);
						}else{
							if(!empty($value))
								$this->turtle_option->insert($data);
						}
					}
				}

				$message = "";

				if(!empty($options->order)){
					$message .= "Turtles.order(".$id.", ". $options->order .");";
				}

				$options = json_encode($options);
				$message .= "Turtles.options(".$id."," . $options . ");";
				$this->xmpp_lib->sendMessage($infoscreen->hostname, $message);
			}
		} catch (ErrorException $e) {
			$this->_throwError('500', $e->getMessage());
		}
	}

	/**
	 * Update turtle order from a screen owned by the authenticated customer
	 *
	 * HTTP method: POST
	 * Roles allowed: admin
	 */
	function turtle_order_post($alias, $id) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$this->load->model('turtle');
		if (!$result = $this->turtle->get($id))
			$this->_throwError('404', ERROR_NO_TURTLE_WITH_ID);

		$data['order'] = $this->input->post('order');
		if(!$this->input->post('order')){
			$data['order'] = 0;
		}

		try {
			$this->turtle->update($id, $data);
			$this->xmpp_lib->sendMessage($infoscreen->hostname, "Turtles.order(".$id."," . $data['order'] . ");");
		} catch (ErrorException $e) {
			$this->_throwError('500', $e->getMessage());
		}
	}

	/**
	 * Remove a turtle from a screen owned by the authenticated customer
	 *
	 * HTTP method: DELETE
	 * Roles allowed: admin
	 */
	function turtle_delete($alias, $id) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

		$this->load->model('turtle');
		if (!$turtle = $this->turtle->get($id))
			$this->_throwError('404', ERROR_NO_TURTLE_WITH_ID);

		// Delete the turtle instance
		$this->turtle->delete($turtle[0]);

		$this->xmpp_lib->sendMessage($infoscreen->hostname, "Turtles.kill(".$id.");");
	}

	/**
	 * Get all jobs for the currently authenticated customer for a specific screen
	 *
	 * HTTP method: GET
	 * Roles allowed: admin
	 */
	function jobs_get($alias = false) {
		$infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

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