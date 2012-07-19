<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Switcher extends MY_Controller
{
    function focus_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$id = $this->input->post('turtle'))
            $this->_throwError('400', ERROR_NO_TURTLE_ID_IN_POST);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Switcher.turtle(" . $$id . ");");
    }

    function rotate_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Switcher.rotate();");
    }

    function start_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Switcher.start();");
    }

    function stop_post($host){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($host, "Switcher.stop();");
    }
}
