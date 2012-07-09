<?php
/**
 * © 2012 FlatTurtle bvba 
 * Author: Pieter Colpaert pieter aŧ flatturtle.com
 * License: AGPLv3
 */
class Guicontroller extends MY_Controller{
    public function GET($matches){
        //First let's check if you're logged in
        if($this->isAuthenticated()){
            $host = $matches[1];
            $arg = array();
            if(isset($matches[2])){
                $args = explode("/",$matches[2]);
            }
            //$this->load->view('header');
            //include_once("../views/header.html");
            $this->hostname = $host;
            $this->load->view('combined');
            //include_once("../views/" .strtolower("touchturtle.html"));
            //include_once("../views/footer.html");
        }else{
            echo "You're not authorized";
        }
    }
        
    public function isAuthenticated(){
        return true;
    }
    public function index(){
        $this->load->view('welcome_message');
    }
}
?>
