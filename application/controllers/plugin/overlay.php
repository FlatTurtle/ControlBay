<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Overlay extends MY_Controller
{
    function add_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$url = $this->input->post('url'))
            $this->_throwError('400', ERROR_NO_URL_IN_POST);

        if(!$timeout = $this->input->post('timeout'))
            $timeout = 0;

        $this->xmpp_lib->sendMessage($this->authorization->host, "Overlay.add('$url', $timeout);");
    }

    function remove_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Overlay.remove();");
    }
}
