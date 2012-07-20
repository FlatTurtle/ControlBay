<?php
/**
 * Proxy to the jaxl xmpp library
 *
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class XMPP_lib
{
    /**
     * Send a message to a certain client
     *
     * @param $host the hosname of the receiver
     * @param $msg the message to send
     */
    function sendMessage($host, $msg){
        $msg = str_replace("\"","\\\"", $msg);
        $msg = str_replace("$","\\$", $msg);

        exec("php " . APPPATH . "libraries/xmpp/sendxmpp.php \"$host@botnet.corp.flatturtle.com\" \"$msg\"");
    }
}
