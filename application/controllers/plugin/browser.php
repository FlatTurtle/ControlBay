<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Browser extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->_authorized){
            $this->output->set_status_header('403');
            exit;
        }
    }

    function browse_post(){
        enforceRole($this->_role, AUTH_ADMIN, $this->output);

        if(!$url = $this->input->post('url')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->_host, "Browser.go('" . $url . "');");
    }
}
