<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Screen extends Plugin_Base {

    private $type = 'power';
    /**
     * Get the status of the screen
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    function power_get($alias) {
        echo parent::get_state($alias, $this->type);
    }

    /**
     * Turn the screen on or off
     *
     * HTTP method: POST
     * POST vars: 'action' : 'on'
     * Roles allowed: admin
     */
    function power_post($alias) {
        $infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

        if (!$action = $this->input->post('action'))
            $this->_throwError('400', ERROR_NO_ACTION_IN_POST);

        if ($action == "off"){
            $command = 'Power.disable();';
        }else{
            $command = 'Power.enable();';
        }

        // Save state
        $this->power_state_post($alias, $action);
        // Issue command
        $this->xmpp_lib->sendMessage($infoscreen->hostname, $command);
    }

    /**
     * Save plugin state for power
     */
    function power_state_post($alias, $state = null){
        if (!$infoscreen = $this->infoscreen->get_by_alias($alias))
            $this->_throwError('404', ERROR_NO_INFOSCREEN);

        $action = $this->input->post('state');
        if(!empty($action)){
            $state = $action;
        }

        if($state == null){
            return;
        }

        if($state == "off"){
            $state = 0;
        }else{
            $state = 1;
        }

        $this->infoscreen->set_plugin_state($infoscreen->id, $this->type, $state);
    }

    /**
     * Reload the screen
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    function reload_post($alias) {
        $infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

        $command =  "location.reload(true)";
        if(!empty($infoscreen->hostname)){
            $command = "location = 'https://go.flatturtle.com/" . $infoscreen->hostname . "'";
        }

        $this->xmpp_lib->sendMessage($infoscreen->hostname, $command);
    }

}