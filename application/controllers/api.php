<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs, Michiel Vancoillie
 * Licence: AGPLv3
 */

class API extends MY_Controller
{
    /**
     * Get all the infoscreens owned by the authenticated customer
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function infoscreens_get(){
        if(!$this->input->get_request_header('Authorization')){
			redirect('http://flatturtle.com');
		}
        $this->authorization->authorize(AUTH_ADMIN);

        try{
            $result = $this->infoscreen->get_by_customer_id($this->authorization->customer_id);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }

        $this->output->set_output(json_encode($result));
    }

    /**
     * Get a specific infoscreen owned by the authenticated customer
     *
     * @param $alias
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function infoscreen_get($alias){
        $this->authorization->authorize(AUTH_ADMIN);
		
        try{
            $result = $this->infoscreen->get_by_alias($alias);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }
		
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->output->set_output(json_encode($result));
    }

    /**
     * Change the details of the given infoscreen
	 * 
     * HTTP method: PUT
     * Roles allowed: admin
     */
    function infoscreen_put($alias){
        $this->authorization->authorize(AUTH_ADMIN);
    }
	
	  /**
     * Get all registered panes for the currently authenticated customer for a specific screen
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function panes_get($alias = false){
        $this->authorization->authorize(array(AUTH_ADMIN));

        if(!$alias)
            $alias = $this->authorization->alias;
		
        if(!$infoscreen = $this->infoscreen->get_by_alias($alias))
            $this->_throwError('404', ERROR_NO_INFOSCREEN);
		
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->load->model('pane');
        if(!$panes = $this->pane->get_by_infoscreen_id($infoscreen[0]->id)){
            $this->_throwError('404', ERROR_NO_TURTLES);
        }

        $this->output->set_output(json_encode($panes));
    }

    /**
     * Get all registered Turtles for the currently authenticated customer for a specific screen
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function turtles_get($alias = false){
        $this->authorization->authorize(array(AUTH_ADMIN, AUTH_MOBILE, AUTH_TABLET));

        if(!$alias)
            $alias = $this->authorization->alias;
		
        if(!$infoscreen = $this->infoscreen->get_by_alias($alias))
            $this->_throwError('404', ERROR_NO_INFOSCREEN);
		
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->load->model('turtle');
        if(!$turtles = $this->turtle->get_by_infoscreen_id_with_options($infoscreen[0]->id)){
            $this->_throwError('404', ERROR_NO_TURTLES);
        }

        $this->output->set_output(json_encode($turtles));
    }

    /**
     * Get a specific turtle with turtle options registered to the currently authenticated customer
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function turtle_get($alias, $id){
        $this->authorization->authorize(AUTH_ADMIN);
    }

    /**
     * Register a new turtle to a screen owned by the authenticated customer
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    function turtle_post($alias, $id){
        $this->authorization->authorize(AUTH_ADMIN);
    }

    /**
     * Remove a turtle from a screen owned by the authenticated customer
     *
     * HTTP method: DELETE
     * Roles allowed: admin
     */
    function turtle_delete($alias, $id){
        $this->authorization->authorize(AUTH_ADMIN);
    }

    /**
     * Edit a turtle with turtle options included
     *
     * HTTP method: PUT
     * Roles allowed: admin
     */
    function turtle_put($alias, $id){
        $this->authorization->authorize(AUTH_ADMIN);
    }
	
	/**
	 * Redirect to stable view
	 */
	function redirect_view($alias){
		redirect(base_url().$alias.'/view/stable');
	}
	
	/**
     * Get all jobs for the currently authenticated customer for a specific screen
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function jobs_get($alias = false){
        $this->authorization->authorize(array(AUTH_ADMIN, AUTH_MOBILE, AUTH_TABLET));

        if(!$alias)
            $alias = $this->authorization->alias;
		
        if(!$infoscreen = $this->infoscreen->get_by_alias($alias))
            $this->_throwError('404', ERROR_NO_INFOSCREEN);
		
		// Check ownership
        if(!$this->infoscreen->isOwner($alias))
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->load->model('jobtab');
        if(!$panes = $this->jobtab->get_by_infoscreen_id($infoscreen[0]->id)){
            $this->_throwError('404', ERROR_NO_TURTLES);
        }

        $this->output->set_output(json_encode($panes));
    }

	
	/**
	 * Export DISCS JSON 
	 */
	function export_json_get($alias){
        try{
            $result = $this->infoscreen->get_by_alias($alias);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }
		
		$this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_output($this->infoscreen->export_json($alias));
	}
}
