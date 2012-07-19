<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Browser extends MY_Controller
{

    function browse_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$url = $this->input->post('url'))
            $this->_throwError('400', ERROR_NO_URL_IN_POST);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Browser.go('" . $url . "');");
    }
}
