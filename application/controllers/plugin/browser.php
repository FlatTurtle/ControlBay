<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Browser extends CI_Controller
{
    function browse($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if(!$url = $this->input->post('url')){
            show_error("No url was given");
        }

        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Browser.go(" . $url . ");");
        }
    }
}
