<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Xmpp
{
    function sendMessage($host, $msg){
        $msg = str_replace("\"","\\\"", $msg);
        $msg = str_replace("$","\\$", $msg);

        exec("php sendxmpp.php \"$host@botnet.corp.flatturtle.com\" \"$msg\"");
    }
}
