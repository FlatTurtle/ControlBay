<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Switcher extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->_authorized){
            $this->output->set_status_header('403');
            exit;
        }
    }

    function focus_post(){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);

        if(!$id = $this->input->post('turtle')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->_host, "Switcher.turtle(" . $$id . ");");
    }

    function rotate_post(){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);

        $this->xmpp_lib->sendMessage($this->_host, "Switcher.rotate();");
    }

    function start_post(){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);

        $this->xmpp_lib->sendMessage($this->_host, "Switcher.start();");
    }

    function stop_post($host){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);

        $this->xmpp_lib->sendMessage($host, "Switcher.stop();");
    }
}
