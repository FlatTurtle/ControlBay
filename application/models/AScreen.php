<?php
/**
 * © 2012 FlatTurtle bvba 
 * Author: Pieter Colpaert pieter aŧ flatturtle.com
 * License: AGPLv3
 */
class AScreen extends CI_Model {

    private $hostname;

    function __construct($host){
        $this->hostname = $host;
    }

    function on(){
        $this->sendMessage($this->hostname, "application.enableScreen(true);");
    }
    
    function off(){
        $this->sendMessage($this->hostname, "application.enableScreen(false);");
    }

    function reload(){
        $this->sendMessage($this->hostname, "location.reload(true);");
    }

    function back(){
        $this->sendMessage($this->hostname, "history.back();");
    }

    function injectMessage($message){
        echo $message;
        //"$(main).html(\"".$message."\"); setTimeout(function(){location.reload(true);},2000);"
        $message = str_replace("'","\\'",$message);
        $this->sendMessage($this->hostname, "$(main).html('<p id=\"koffie\" class=\"color\">".$message."</p><style>#koffie{ color: white; font-size: 80px; text-align: center; border-top: 400px solid white;}</style>'); setTimeout(function(){location.reload(true);},30000);");
    }
    
    function showImage($message){
        echo $message;
        //"$(main).html(\"".$message."\"); setTimeout(function(){location.reload(true);},2000);"
        $message = str_replace("'","\\'",$message);
        $this->sendMessage($this->hostname, "$('.container').html('');$('.container').css({'background': 'black url(".$message.") center center no-repeat'}); setTimeout(function(){location.reload(true);},30000);");
    }

    function browseUrl($message){
        echo $message;
        //"$(main).html(\"".$message."\"); setTimeout(function(){location.reload(true);},2000);"
        $message = str_replace("'","\\'",$message);
        $this->sendMessage($this->hostname, "window.location=\"".$message."\";");
    }

    function sendMessage($host,$msg){
        //echo "Executing";
        //echo "php sendxmpp.php \"$host@botnet.corp.flatturtle.com\" \"$msg\"";
        //escape galore!
        $msg = str_replace("\"","\\\"", $msg);
        $msg = str_replace("$","\\$", $msg);
        exec("php sendxmpp.php \"$host@botnet.corp.flatturtle.com\" \"$msg\"");
    }
}

