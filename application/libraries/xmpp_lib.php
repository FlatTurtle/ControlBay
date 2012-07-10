<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class XMPP_lib
{
    function sendMessage($host, $msg){
        $msg = str_replace("\"","\\\"", $msg);
        $msg = str_replace("$","\\$", $msg);
        //TODO protect against injections

        exec("php " . APPPATH . "libraries/xmpp/sendxmpp.php \"$host@botnet.corp.flatturtle.com\" \"$msg\"");
    }
}
