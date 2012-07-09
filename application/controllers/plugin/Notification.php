<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Notification extends CI_Controller
{

    function add($host, $message){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            sendMessage($host, "Notification.add(".$message.");");
        }
    }

    function remove($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            sendMessage($host, "Notification.remove();");
        }
    }
}
