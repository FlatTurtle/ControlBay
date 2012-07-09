<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Browser extends CI_Controller
{
    function browse($host, $url){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            sendMessage($host, "Browser.go(" . $url . ");");
        }
    }
}
