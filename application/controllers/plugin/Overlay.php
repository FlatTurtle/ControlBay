<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Overlay extends CI_Controller
{
    function add($host, $url){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            sendMessage($host, "Overlay.add('".$url."');");
        }
    }

    function remove($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            sendMessage($host, "Overlay.remove();");
        }
    }
}
