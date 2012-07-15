<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Overlay extends MY_Controller
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
        if(!$url = $this->input->post('url')){
            $this->output->set_response_header('400');
        }

        if(!$timeout = $this->input->post('timeout')){
            $timeout = 0;
        }

        $this->xmpp_lib->sendMessage($this->_host, "Overlay.add('$url', $timeout);");
    }

    function remove_post(){
        $this->xmpp_lib->sendMessage($this->_host, "Overlay.remove();");
    }
}
