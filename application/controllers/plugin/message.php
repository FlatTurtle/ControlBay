<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Message extends CI_Controller
{

    function add($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if(!$message = $this->input->post('message')){
            show_error("No message was given");
        }


        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Message.add(".$message.");");
        }
    }

    function remove($host){
        $method = $_SERVER['REQUEST_METHOD'];

        if($method == "POST"){
            $this->xmpp_lib->sendMessage($host, "Message.remove();");
        }
    }
}
