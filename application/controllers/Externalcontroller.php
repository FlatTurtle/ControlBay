<?php
/**
 * © 2012 FlatTurtle bvba 
 * Author: Pieter Colpaert pieter aŧ flatturtle.com
 * License: AGPLv3
 */
class Externalcontroller extends MY_Controller{

    function POST($matches){
        //First let's check if you're logged in
        if($this->isAuthenticated()){
            $host = $matches[1];
            $arg = array();
            if(isset($matches[2])){
                $args = explode("/",$matches[2]);
            }
            include_once("pages/header.html");
            $this->hostname = $host;
            include_once("pages/" .strtolower("touchturtle.html"));
            include_once("pages/footer.html");
        }else{
            echo "You're not authorized";
        }
    }
        
    function isAuthenticated(){
        var $symm_key = 'glenn';
        $pass = $_POST['password'];
        echo $symm_key;
        if(strcmp($pass,$symm_key) == 0) return true;
        else return false;
    }
}
