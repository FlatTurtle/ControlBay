<?php
require (APPPATH . '/libraries/rest.php');

class Example extends REST_Controller {
    
    function index_get() {
        echo 'get';
    }
    
    function index_post() {
        echo 'post';
    }

}