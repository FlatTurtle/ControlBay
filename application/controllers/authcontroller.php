<?php
/**
 * Created by JetBrains PhpStorm.
 * User: gbostoen
 * Date: 7/12/12
 * Time: 11:37 AM
 * To change this template use File | Settings | File Templates.
 */
class AuthController extends MY_Controller
{
    const ERROR_NO_PIN = "You forgot to pass a pincode in the POST body!";
    const ERROR_PIN_NOT_NUM = "The pincode you provided is not numeric!";
    const ERROR_WRONG_PIN = "The pincode you provided is wrong!";
    const ERROR_NO_USERNAME = "No username in POST body!";
    const ERROR_NO_PASSWORD = "No password in POST body!";
    const ERROR_WRONG_USERNAME_PASSWORD = "The given username or password is wrong";

    /*
     * give access for mobile devices
     */
    function auth_post()
    {
        // no pin parameter in POST -> 400 bad request
        if(!$pin = $this->input->post('pin'))
            $this->_throwError('400', self::ERROR_NO_PIN);

        // pincode not numeric -> 400 bad request
        if(!is_numeric($pin))
            $this->_throwError('400', self::ERROR_PIN_NOT_NUM);

        $this->load->model('infoscreen');
        try{
            $infoscreen = $this->infoscreen->get_by_pin($pin);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }

        // no screen with that pincode -> 403 unauthorized
        if(count($infoscreen) < 1)
            $this->_throwError('403', self::ERROR_WRONG_PIN);

        $this->load->model('public_token');
        if($this->public_token->count() > TOKEN_TABLE_LIMIT){
            $this->public_token->delete_expired();
        }

        // if user already had a token remove it from the database
        if($token = $this->input->post('token')){
            $dbtokens = $this->public_token->get_by_token($token);
            if(count($dbtokens) == 1){
                $this->public_token->delete($dbtokens[0]->id);
            }
        }

        try{
            $token = $this->_storePublicToken($pin, $infoscreen[0]->id);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }
        $this->output->set_output(json_encode($token));
    }

    private function _storePublicToken($pin, $screen_id){
        $data['token'] = sha1(time() . uniqid('', true));
        $data['screen_id'] = $screen_id;
        $data['user_agent'] = $this->input->user_agent();
        $data['ip'] = $this->input->ip_address();
        if($this->_isTablet($pin)){
            $this->_checkScreenForOthers($screen_id);
            $data['role'] = AUTH_TABLET;
            $data['expiration'] = Public_token::getTabletExpiration();
        }else{
            $data['role'] = AUTH_MOBILE;
            $data['expiration'] = Public_token::getMobileExpiration();
        }
        $this->public_token->insert($data);
        return $data['token'];
    }

    private function _isTablet(){
        if(!$key = $this->input->post('dedicated_key'))
            return false;

        return $this->_verifykey($key);
    }

    private function _verifyKey($key){
        if($key === $this->config->item('tablet_key'))
            return true;

        return false;
    }

    /*
     * give access to admin
     */
    function auth_login_post()
    {
        if(!$username = $this->input->post('username'))
            $this->_throwError('400', self::ERROR_NO_USERNAME);

        if(!$password = $this->input->post('password'))
            $this->_throwError('400', self::ERROR_NO_PASSWORD);

        $this->load->model('customer');
        $userRow = $this->customer->get_by_username($username);

        if(count($userRow)<1){
            $this->output->set_status_header('403');
            return;
        }

        $this->load->library('phpass_lib');
        if(!$this->phpass_lib->checkPassword($password, $userRow[0]->password))
            $this->_throwError("403", self::ERROR_WRONG_USERNAME_PASSWORD);

        $this->load->model('admin_token');
        if($this->admin_token->count() > TOKEN_TABLE_LIMIT){
            $this->admin_token->delete_expired();
        }
        // if user already had a token remove it from the database
        if($token = $this->input->post('token')){
            $dbtokens = $this->admin_token->get_by_token($token);
            if(count($dbtokens) == 1){
                $this->public_token->delete($dbtokens[0]->id);
            }
        }

        $token = $this->_storeAdminToken($userRow[0]);
        $this->output->set_output(json_encode($token));
    }

    private function _checkScreenForOthers($screen_id)
    {
        $this->load->model('public_token');
        $tokens = $this->public_token->get_by_screen_id($screen_id);
        foreach($tokens as $token){
            if($token->role == AUTH_TABLET)
                $this->public_token->delete($token->id);
        }
    }
    
    private function _storeAdminToken($user){
        $data['token'] = sha1(time() . uniqid('', true));
        $date['customer_id'] = $user->id;
        $data['user_agent'] = $this->input->user_agent();
        $data['ip'] = $this->input->ip_address();
        $data['role'] = AUTH_ADMIN;
        $data['expiration'] = Admin_token::getAdminExpiration();
        $data['customer_id'] = $user->id;
        try {
            $this->admin_token->insert($data);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }

        return $data['token'];
    }
}
