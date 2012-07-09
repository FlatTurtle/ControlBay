<?php
/**
 * This file routes all requests in the right direction
 *
 */
include_once("Config.xmpp.php");
// Send message after successful authentication
function postAuth($payload, $jaxl) {
    global $recipient,$message;
    $jaxl->sendMessage($recipient,$message);
    $jaxl->shutdown();
}

$recipient = "";
if(isset($argv[1])){
    $recipient = $argv[1];
}else{
    print_manual();
    exit(0);
}
$message = "";
if(isset($argv[2])){
    $message = $argv[2];
}else{
    print_manual();
    exit(0);
}

function print_manual(){
    echo "Usage: php sendxmpp.php \"recipient@foo.com\" \"your message\"\n";
}

//this starts the xmpp connection
// Include and initialize Jaxl core
require_once 'core/jaxl.class.php';
$jaxl = new JAXL(Config::$xmpparray);
// Register callback on required hook (callback'd method will always receive 2 params)
$jaxl->addPlugin('jaxl_post_auth', 'postAuth');
// Start Jaxl core
$jaxl->startCore('stream');
