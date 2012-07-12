<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gbostoen
 * Date: 7/12/12
 * Time: 11:37 AM
 * To change this template use File | Settings | File Templates.
 */
require (APPPATH . '/libraries/rest.php');

class authcontroller extends REST_Controller
{
    /*
     * give access for mobile devices
     */
    function auth_limited_get($pin)
    {
        $this->load->model('infoscreen');
        if(is_numeric($pin)){
            $result = $this->infoscreen->get_by_pin($pin);
            //check screen found on pin
            if($result['success']){
                $this->load->model('p_token');
                $result = $this->p_token->get_by_screen_id($result['result'][0]->id);
                //check P_token found
                if($result['success']){
                    //update token
                }
                else{
                    //insert token
                }
                //$this->output->set_output(json_encode(array("success"=>1,$result['result'])));
            }
            else{
                //screen not found
                $this->output->set_output(json_encode(array('success'=>0)));
            }
        }
        else{
            //not a numeric pincode
            $this->output->set_output(json_encode(array("success"=>0)));
        }
    }
    /*
     * give access for dedicated tablet devices
     */
    function auth_unlimited_get($pin)
    {
        $this->load->model('infoscreen');
        if(is_numeric($pin)){
            $result = $this->infoscreen->get_by_pin($pin);
            //check screen found on pin
            if($result['success']){
                $this->load->model('p_token');
                $result = $this->p_token->get_by_screen_id($result['result'][0]->id);
                //check P_token found
                if($result['success']){
                    //update token
                }
                else{
                    //insert token
                }
                //$this->output->set_output(json_encode(array("success"=>1,$result['result'])));
            }
            else{
                //screen not found
                $this->output->set_output(json_encode(array('success'=>0)));
            }
        }
        else{
            //not a numeric pincode
            $this->output->set_output(json_encode(array("success"=>0)));
        }
    }
    /*
     * give access to admin
     */
    function auth_login_get($admin,$pass)
    {
        //give admin access with token
    }
}