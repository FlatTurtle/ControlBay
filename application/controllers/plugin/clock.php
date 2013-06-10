<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
require_once APPPATH . "controllers/plugin/plugin_base.php";

class Clock extends Plugin_Base{

    private $type = 'clock';

    /**
     * Get status of the clock for an infoscreen
     *
     * HTTP method: GET
     * Roles allowed: admin
     */
    public function index_get($alias){
        echo parent::get_state($alias, $this->type);
    }

    /**
     * Add the clock to the infoscreen
     *
     * HTTP method: POST
     * Roles allowed: admin
     */
    public function index_post($alias){
        $infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);

        $this->infoscreen->set_plugin_state($infoscreen->id, $this->type, 1);

        $this->xmpp_lib->sendMessage($infoscreen->hostname, "Clock.enable();");
    }

    /**
     * Remove the clock from the infoscreen
     *
     * HTTP method: DELETE
     * Roles allowed: admin
     */
    public function index_delete($alias){
        $infoscreen = parent::validate_and_get_infoscreen(AUTH_ADMIN, $alias);
        $this->infoscreen->disable_plugin($infoscreen->id, $this->type);

        $this->xmpp_lib->sendMessage($infoscreen->hostname, "Clock.disable();");
    }
}
