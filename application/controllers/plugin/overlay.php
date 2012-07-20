<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Overlay extends MY_Controller
{
    /**
     * Authorizes a call to display an image on the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * POST vars: 'url' : 'some image url'
     * Roles allowed: admin
     * Url: example.com/plugin/overlay/add
     */
    function add_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$url = $this->input->post('url'))
            $this->_throwError('400', ERROR_NO_URL_IN_POST);

        if(!$timeout = $this->input->post('timeout'))
            $timeout = 0;

        $this->xmpp_lib->sendMessage($this->authorization->host, "Overlay.add('$url', $timeout);");
    }

    /**
     * Authorizes a call to remove an image from the screen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * Roles allowed: admin
     * Url: example.com/plugin/overlay/remove
     */
    function remove_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Overlay.remove();");
    }
}
