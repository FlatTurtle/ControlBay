<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Magnify extends MY_Controller
{

    function turtle_post(){
        $this->authorization->authorize($this->_role, array(AUTH_MOBILE, AUTH_TABLET, AUTH_ADMIN));

        if(!$turtle = $this->input->post('turtle')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->_host, "Magnify.turtle(".$turtle.");");
    }
}
