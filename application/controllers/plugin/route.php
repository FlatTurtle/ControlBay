<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Route extends Plugin_Base {

    function __construct()
    {
        parent::__construct();
        $this->load->model('pane');
        $this->load->model('turtle');
    }

    /**
     * Display a fullscreen turtle for the requested NMBS route
     */
    function nmbs_post($alias) {
        $infoscreen = parent::validate_and_get_infoscreen(array(AUTH_ADMIN, AUTH_TABLET), $alias);

        if (!$from = $this->input->post('from'))
            $this->_throwError('400', ERROR_MISSING_PARAMETER);

        if (!$to = $this->input->post('to'))
            $this->_throwError('400', ERROR_MISSING_PARAMETER);

        $panes = $this->pane->get_by_type($infoscreen->id, 'hidden');
        $turtles = $this->turtle->get_by_infoscreen_id($infoscreen->id);

        if(count($panes) <= 0 || count($turtles) <= 0){
            return;
        }
        $route_turtle = null;
        foreach($turtles as $turtle){
            if($turtle->type == 'route')
                $route_turtle = $turtle;
        }

        if($route_turtle == null) return;

        $message = "Panes.fullscreen(". $panes[0]->id.", 30000);";
        $message .= "Turtles.options(".$route_turtle->id.",{from:'" . $from . "', to:'" . $to . "', route_type:'nmbs'});";
        $this->xmpp_lib->sendMessage($infoscreen->hostname, $message);
    }

    /**
     * Display a fullscreen turtle for the requested NMBS station
     */
    function board_post($alias) {
        $infoscreen = parent::validate_and_get_infoscreen(array(AUTH_ADMIN, AUTH_TABLET), $alias);
        if (!$station = $this->input->post('station'))
            $this->_throwError('400', ERROR_MISSING_PARAMETER);

        if (!$type = $this->input->post('type'))
            $type = 'Departures';

        if (!$route_type = $this->input->post('route_type'))
            $route_type = 'nmbs';

        $panes = $this->pane->get_by_type($infoscreen->id, 'hidden');
        $turtles = $this->turtle->get_by_infoscreen_id($infoscreen->id);

        if(count($panes) <= 0 || count($turtles) <= 0){
            return;
        }
        $route_turtle = null;
        foreach($turtles as $turtle){
            if($turtle->type == 'route')
                $route_turtle = $turtle;
        }

        if($route_turtle == null) return;

        $message = "Panes.fullscreen(". $panes[0]->id.", 30000);";
        $message .= "Turtles.options(".$route_turtle->id.",{station:'" . $station . "', type:'" . $type . "', route_type:'".$route_type."'});";
        $this->xmpp_lib->sendMessage($infoscreen->hostname, $message);
    }

}

?>