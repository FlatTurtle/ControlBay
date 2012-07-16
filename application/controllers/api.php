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
     */
    function infoscreens_get(){

    }

    /**
     * Get a specific infoscreen owned by the authenticated customer
     *
     * @param $id
     */
    function infoscreen_get($id){

    }

    /**
     * Insert a new infoscreen with as owner the currently authenticated customer
     */
    //function infoscreens_post(){

    //}

    /**
     * Change the details of the given infoscreen
     */
    function infoscreen_put(){

    }

    /**
     * Get all registered Turtles for the currently authenticated customer for a specific screen
     */
    function turtles_get(){
        if(!isset($this->_host)){
            $this->output->set_status_header('400');
            return;
        }

        $this->load->model('infoscreen');
        if(!$infoscreen = $this->infoscreen->get_by_hostname($this->_host)){
            $this->output->set_status_header('400');
            return;
        }

        $this->load->model('turtle');
        if(!$turtles = $this->turtle->get_by_screen_id_with_options($infoscreen[0]->id)){
            $this->output->set_status_header('400');
            return;
        }

        $this->output->set_output(json_encode($turtles));
    }

    /**
     * Get a specific turtle registered to the currently authenticated customer
     *
     * @param $id
     */
    function turtle_get($id){

    }

    /**
     * Register a new turtle to a screen owned by the authenticated customer
     */
    function turtle_post(){

    }

    /**
     * Unregister a turtle to a screen owned by the authenticated customer
     */
    function turtle_delete(){

    }

    /**
     * Edit a turtle
     */
    function turtle_put($id, $data){

    }
}
