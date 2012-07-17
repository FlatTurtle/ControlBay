<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Magnify extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->_authorized){
            $this->output->set_status_header('403');
            exit;
        }
    }

    function turtle_post(){
        enforceRole($this->_role, AUTH_ALL, $this->output);

        if(!$turtle = $this->input->post('turtle')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->_host, "Magnify.turtle(".$turtle.");");
    }
}
