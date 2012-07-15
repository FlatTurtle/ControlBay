<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Magnify extends MY_Controller
{
    function turtle_post(){
        if(!$turtle = $this->input->post('turtle')){
            $this->output->set_response_header('400');
        }

        $this->xmpp_lib->sendMessage($this->host, "Magnify.turtle(".$turtle.");");
    }
}
