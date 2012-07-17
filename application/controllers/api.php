<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */

class API extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!$this->_authorized){
            $this->output->set_status_header('403');
            exit;
        }
    }

    /**
     *  Get all the infoscreens owned by the authenticated customer
     *
     *  accessible by ADMIN role
     */
    function infoscreens_get(){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);

    }

    /**
     * Get a specific infoscreen owned by the authenticated customer
     *
     * @param $id
     *
     *  accessible by ADMIN role
     */
    function infoscreen_get($id){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);

    }

    /**
     * Insert a new infoscreen with as owner the currently authenticated customer
     */
    //function infoscreens_post(){

    //}

    /**
     * Change the details of the given infoscreen
     *
     *  accessible by ADMIN role
     */
    function infoscreen_put(){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);

    }

    /**
     * Get all registered Turtles for the currently authenticated customer for a specific screen
     *
     *  accessible by ALL roles
     */
    function turtles_get(){
        enforceRole($this->_role, AUTH_ALL, $this->output);

        if(!isset($this->_host)){
            $this->output->set_status_header('400');
            return;
        }

        $this->load->model('infoscreen');
        if(!$infoscreen = $this->infoscreen->get_by_hostname($this->_host)){
            $this->output->set_status_header('404');
            return;
        }

        $this->load->model('turtle');
        if(!$turtles = $this->turtle->get_by_screen_id_with_options($infoscreen[0]->id)){
            $this->output->set_status_header('404');
            return;
        }

        $this->output->set_output(json_encode($turtles));
    }

    /**
     * Get a specific turtle with turtle options registered to the currently authenticated customer
     *
     * @param $id
     *
     * accessible by ADMIN role
     */
    function turtle_get($id){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);
    }

    /**
     * Register a new turtle to a screen owned by the authenticated customer
     *
     * accessible by ADMIN role
     */
    function turtle_post(){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);
    }

    /**
     * Remove a turtle from a screen owned by the authenticated customer
     *
     * accessible by ADMIN role
     */
    function turtle_delete(){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);
    }

    /**
     * Edit a turtle with turtle options included
     *
     * accessible by ADMIN role
     */
    function turtle_put($id){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);
    }
}
