<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Clock extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->_authorized){
            $this->output->set_status_header('403');
            exit;
        }
    }

    function add_post(){
            $this->xmpp_lib->sendMessage($this->_host, "Clock.add();");
    }

    function remove_post($host){
            $this->xmpp_lib->sendMessage($this->_host, "Clock.remove();");
    }
}
