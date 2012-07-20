<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Magnify extends MY_Controller
{
    /**
     * Authorizes a call to magnify a turtle on the infoscreen
     * Translates it to xmmp
     *
     * HTTP method: POST
     * POST vars: 'turtle' : 'a turtle id'
     * Roles allowed: mobile, tablet, admin
     * Url: example.com/plugin/magnify/turtle
     */
    function turtle_post(){
        $this->authorization->authorize(array(AUTH_MOBILE, AUTH_TABLET, AUTH_ADMIN));

        if(!$turtle = $this->input->post('turtle'))
            $this->_throwError('400', ERROR_NO_TURTLE_ID_IN_POST);

        if(!is_numeric($turtle))
            $this->_throwError('400', ERROR_TURTLE_ID_NOT_NUMERIC);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Magnify.turtle(".$turtle.");");
    }
}
