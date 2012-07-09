<?php
/**
 * © 2012 FlatTurtle bvba 
 * Author: Pieter Colpaert pieter aŧ flatturtle.com
 * License: AGPLv3
 */
class MY_Controller extends CI_Controller{
    
    private $pagetitle;
    
    function GET($matches){
        if(file_exists("pages/" .strtolower(get_class($this)) .".html")){
            $this->pagetitle = get_class($this);
            include_once("pages/header.html");
            include_once("pages/" .strtolower(get_class($this)) .".html");
            include_once("pages/footer.html");
        }elseif(file_exists("pages/" .strtolower($matches[1]) .".html")){
            $this->pagetitle = $matches[1];
            include_once("pages/header.html");
            include_once("pages/" .strtolower($matches[1]) .".html");
            include_once("pages/footer.html");
        }else{
            //when inside the browser, redirect to our 404
            $this->pagetitle = "404";
            echo "<script>location = '" . Config::$HOSTNAME . Config::$SUBDIR . "404';</script>";
            throw new Exception("Page not found.", 404);
        }
    }

    function title(){
        return get_class($this);
    }

    function PUT($matches){
        throw new Exception("Don't PUT this resource. You're probably trying something nasty.");
    }

    function DELETE($matches){
        throw new Exception("Don't DELETE this resource. You're probably trying something nasty.");
    }

    function POST($matches){
        throw new Exception("Don't POST this resource. You're probably trying something nasty.");
    }

    function baseurl($url){
        echo Config::$HOSTNAME . Config::$SUBDIR . $url;
    }
    function index(){
        $this->load->view('welcome_message');
    }
}
