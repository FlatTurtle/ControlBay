<?php

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->output->set_content_type('application/json');
        $this->load->helper('url');
        if(defined('ENVIRONMENT')){
            switch (ENVIRONMENT)
            {
                case 'development':
                    break;
                default :
                    if (array_key_exists('HTTPS', $_SERVER)) {
                        if ($_SERVER['HTTPS'] != 'on') {
                            header('Location:'.base_url(uri_string()));
                            exit;
                        }
                    } //check on https connection, could also check $_SERVER['HTTPS'] but isn't provided on every server
					else if ($_SERVER['SERVER_PORT'] != 443) {
                        header('Location:'.base_url(uri_string()));
                        exit;
                    }
                    break;
            }
        }
    }

    /**
     * Helper function to return errors and set the HTTP status code
     *
     * @param $code the HTTP status code
     * @param $message the message to return to the user
     */
    protected function _throwError($code, $message){
        $this->output->set_status_header($code);
        echo $message;
        exit;
    }

    /**
     * Helper function to log database exceptions and exit
     *
     * @param $ex the thrown exception
     */
    protected function _handleDatabaseException($ex){
        log_message("Database error: " . $ex->getMessage());
        exit;
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
        } else if(method_exists($this, $method)){
            return call_user_func_array(array($this, $method), $args);
        }else{
            $this->_throwError('404', ERROR_ACTION_DOES_NOT_EXIST);
        }
    }

}
