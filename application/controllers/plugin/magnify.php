<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Magnify extends MY_Controller
{
    const ERROR_NO_TURTLE_ID_IN_POST = "No turtle id in POST body!";

    function turtle_post(){
        $this->authorization->authorize(array(AUTH_MOBILE, AUTH_TABLET, AUTH_ADMIN));

        if(!$turtle = $this->input->post('turtle'))
            $this->_throwError('400', self::ERROR_NO_TURTLE_ID_IN_POST);

        $this->xmpp_lib->sendMessage($this->authorization->host, "Magnify.turtle(".$turtle.");");
    }
}
