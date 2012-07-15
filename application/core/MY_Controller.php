<?php

class MY_Controller extends CI_Controller {

    protected $host;
    protected $role;

    public function __construct() {
        parent::__construct();
        $this->output->set_content_type('application/json');
        if(defined('ENVIRONMENT')){
            switch (ENVIRONMENT)
            {
                case 'development':
                    break;
                default :
                    if (array_key_exists('HTTPS', $_SERVER)) {
                        if ($_SERVER['HTTPS'] != 'on') {
                            $this->output->set_status_header('403');
                            exit;
                        }
                    } //check on https connection, could also check $_SERVER['HTTPS'] but isn't provided on every server
					else if ($_SERVER['SERVER_PORT'] != 443) {
                        $this->output->set_status_header('403');
                        exit;
                    }
                    break;
            }
        }

        if(!$this->_isAuthorized()){
            $this->output->set_status_header('403');
            exit;
        }
    }

    private function _isAuthorized(){
        if(!$token = $this->input->post('token'))
            return false;

        //TODO differentiate between public tokens and admin tokens
        $this->load->model('public_token');
        $dbtoken = $this->public_token->get_by_token($token);
        if(count($dbtoken) < 1)
            return false;

        $dbtoken = $dbtoken[0];
        if( $dbtoken->expiration < date(new DateTime()) ||
            $dbtoken->ip != $this->input->ip_address() ||
            $dbtoken->user_agent != $this->input->user_agent())
        {
            try{
                $this->public_token->delete($dbtoken->id);
            }catch(ErrorException $e){
                // log database error
            }
            return false;
        }

        $this->load->model('infoscreen');
        $infoscreen = $this->infoscreen->get($dbtoken->screen_id);
        if(count($infoscreen) == 1){
            $this->host = $infoscreen[0]->hostname;
            $this->role = $dbtoken->role;
        }else
            return false;

        return true;
    }

    /**
     * Remap methods with request method concatinated
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function _remap($method, $args = array()) {
        $request_method = strtolower($this->input->server('REQUEST_METHOD'));
        
        if (method_exists($this, $method . '_' . $request_method)) {
            return call_user_func_array(array($this, $method . '_' . $request_method), $args);
        } else {
            return call_user_func_array(array($this, $method), $args);
        }
    }

}