<?php
/**
 * © 2012 FlatTurtle bvba 
 * Author: Pieter Colpaert pieter aŧ flatturtle.com
 * License: AGPLv3
 */
class Screencontroller extends MY_Controller{
    function GET($matches){
        //First let's check if you're logged in
        if($this->isAuthenticated()){
            $host = $matches[1];
            $args = explode("/",$matches[2]);
        }else{
            echo "You're not authorized";
        }
    }

    function POST($matches){
        if($this->isAuthenticated()){
            $host = urldecode($matches[1]);
            if($host != "testclient" && $host != "efikamx-561dcb" && $host != "efikamx--5fb019"){ // In meantime
                echo "Stop hacking";
                exit(0);
            }
            include_once("model/AScreen.class.php");
            $model = new AScreen($host);
            $args = explode("/",$matches[2]);
            $func = $args[0];
            if($func == "power"){
                if(isset($_POST["value"])){
                    $value = $_POST["value"];
                    if($value == "on"){
                        $model->on();
                    }else{
                        $model->off();
                    }
                }else{
                    echo "you didn't provide any POST parameters";
                }
            }else if($func == "status"){
                if(isset($_POST["value"])){
                    $value = $_POST["value"];
                    if($value == "reload"){
                        $model->reload();
                    }else if($value == "back"){
                        $model->back();
                    }else if($value == "message"){
                        if(isset($_POST["message"])){
                            $model->injectMessage($_POST["message"]);
                        }
                    } 
                }else{
                    echo "you didn't provide any POST parameters";
                }  
                
            }else if($func == "image"){
                if(isset($_POST["message"])){
                    $model->showImage($_POST["message"]);
                }else{
                    echo "you didn't provide any POST parameters";
                }  
            }else if($func == "url"){
                if(isset($_POST["message"])){
                    $model->browseUrl($_POST["message"]);
                }else{
                    echo "you didn't provide any POST parameters";
                }
            }
            
        }else{
            echo "You're not authorized";
        }
    }

    function isAuthenticated(){
        return true;
    }
}
