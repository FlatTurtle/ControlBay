<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Taxi extends Plugin_Base {

    function __construct(){
        parent::__construct();
        $this->load->model('pane');
        $this->load->model('turtle');
    }

    /**
     * Display a fullscreen turtle with taxi numbers
     */
    function show_post($alias) {
        $infoscreen = parent::validate_and_get_infoscreen(array(AUTH_ADMIN, AUTH_TABLET), $alias);

        if (!$from = $this->input->post('from'))
            $this->_throwError('400', ERROR_MISSING_PARAMETER);

        if (!$to = $this->input->post('to'))
            $this->_throwError('400', ERROR_MISSING_PARAMETER);

        $panes = $this->pane->get_by_type($infoscreen->id, 'hidden');

        if(count($panes) <= 0 || count($turtles) <= 0){
            return;
        }

        $message = "Panes.fullscreen(". $panes[0]->id.", 25000);";
        $this->xmpp_lib->sendMessage($infoscreen->hostname, $message);
    }
}