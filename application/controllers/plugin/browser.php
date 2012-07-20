<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Browser extends MY_Controller
{

    /**
     * Authorizes a client call to display another website on the infoscreen
     * Translates the call to an xmpp message
     *
     * HTTP method: POST
     * POST vars: 'url': 'a url'
     * Roles allowed: admin
     * Url: example.com/plugin/browser/browse
     */
    function browse_post(){
        $this->authorization->authorize(AUTH_ADMIN);

        if(!$url = $this->input->post('url'))
            $this->_throwError('400', ERROR_NO_URL_IN_POST);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Browser.go('" . $url . "');");
    }
}
