<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
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
        $this->authorization->authorize(AUTH_ADMIN);

        $this->load->model('infoscreen');

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
     * @param $id
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function infoscreen_get($id){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->load->model('infoscreen');
        try{
            $result = $this->infoscreen->get($id);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }
        if($result[0]->customer_id != $this->authorization->customer_id)
            $this->_throwError('403', ERROR_NO_OWNERSHIP_SCREEN);

        $this->output->set_output(json_encode($result));
    }

    /**
     * Change the details of the given infoscreen
     *
     * HTTP method: PUT
     * Roles allowed: admin
     */
    function infoscreen_put(){
        $this->authorization->authorize(AUTH_ADMIN);
    }

    /**
     * Get all registered Turtles for the currently authenticated customer for a specific screen
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function turtles_get($host = false){
        $this->authorization->authorize(array(AUTH_ADMIN, AUTH_MOBILE, AUTH_TABLET));

        if(!$host)
            $host = $this->authorization->host;

        $this->load->model('infoscreen');
        if(!$infoscreen = $this->infoscreen->get_by_hostname($host))
            $this->_throwError('404', ERROR_NO_INFOSCREEN);


        $this->load->model('turtle');
        if(!$turtles = $this->turtle->get_by_screen_id_with_options($infoscreen[0]->id)){
            $this->_throwError('404', ERROR_NO_TURTLES);
        }

        $this->output->set_output(json_encode($turtles));
    }

    /**
     * Get a specific turtle with turtle options registered to the currently authenticated customer
     *
     * @param $id
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function turtle_get($id){
        $this->authorization->authorize(AUTH_ADMIN);
    }

    /**
     * Register a new turtle to a screen owned by the authenticated customer
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    function turtle_post(){
        $this->authorization->authorize(AUTH_ADMIN);
    }

    /**
     * Remove a turtle from a screen owned by the authenticated customer
     *
     * HTTP method: DELETE
     * Roles allowed: admin
     */
    function turtle_delete(){
        $this->authorization->authorize(AUTH_ADMIN);
    }

    /**
     * Edit a turtle with turtle options included
     *
     * HTTP method: PUT
     * Roles allowed: admin
     */
    function turtle_put($id){
        $this->authorization->authorize(AUTH_ADMIN);
    }
}
