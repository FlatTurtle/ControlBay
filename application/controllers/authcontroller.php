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
    /**
     * The POST method to authorize as mobile (smartphone / tablet)
     *
     * HTTP method: POST
     * POST vars:   'pin': 'a pincode'
     * Roles allowed: All
     * Url: example.com/auth/mobile
     */
    function auth_post()
    {
        // no pin parameter in POST -> 400 bad request
        if(!$pin = $this->input->post('pin'))
            $this->_throwError('400', ERROR_NO_PIN);

        // pincode not numeric -> 400 bad request
        if(!is_numeric($pin))
            $this->_throwError('400', ERROR_PIN_NOT_NUM);

        $this->load->model('infoscreen');
        try{
            $infoscreen = $this->infoscreen->get_by_pin($pin);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }

        // no screen with that pincode -> 403 unauthorized
        if(count($infoscreen) < 1)
            $this->_throwError('403', ERROR_WRONG_PIN);

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
            $token = $this->_storePublicToken($infoscreen[0]->id);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }
        $this->output->set_output(json_encode($token));
    }


    /**
     * The basic authentication for admins
     *
     * HTTP method: POST
     * POST vars:   'username' : 'the username'
     *              'password' : 'the password'
     * Roles allowed: ALL
     * Url: example.com/auth/admin
     */
    function auth_login_post()
    {
        // no username in post -> bad request
        if(!$username = $this->input->post('username'))
            $this->_throwError('400', ERROR_NO_USERNAME);

        // no password in post -> bad request
        if(!$password = $this->input->post('password'))
            $this->_throwError('400', ERROR_NO_PASSWORD);

        $this->load->model('customer');
        $userRow = $this->customer->get_by_username($username);

        // no user found with that username -> forbidden
        if(count($userRow)<1)
            $this->_throwError('403', ERROR_WRONG_USERNAME_PASSWORD);

        $this->load->library('phpass_lib');
        if(!$this->phpass_lib->checkPassword($password, $userRow[0]->password))
            $this->_throwError("403", ERROR_WRONG_USERNAME_PASSWORD);

        $this->load->model('admin_token');
        if($this->admin_token->count() > TOKEN_TABLE_LIMIT){
            $this->admin_token->delete_expired();
        }
        // if user already had a token remove it from the database
        if($token = $this->input->post('token')){
            $dbtokens = $this->admin_token->get_by_token($token);
            if(count($dbtokens) == 1){
                $this->admin_token->delete($dbtokens[0]->id);
            }
        }

        $token = $this->_storeAdminToken($userRow[0]);
        $this->output->set_output(json_encode($token));
    }


    /**
     * Create a new entry in the admin_tokens table and return the newly created token
     *
     * @param $screen_id the screen that the new token references
     * @return mixed the newly created token
     */
    private function _storePublicToken($screen_id){
        $data['token'] = sha1(time() . uniqid('', true));
        $data['screen_id'] = $screen_id;
        $data['user_agent'] = $this->input->user_agent();
        $data['ip'] = $this->input->ip_address();
        if($this->_isTablet()){
            $this->_RemoveOthersOnScreen($screen_id);
            $data['role'] = AUTH_TABLET;
            $data['expiration'] = Public_token::getTabletExpiration();
        }else{
            $data['role'] = AUTH_MOBILE;
            $data['expiration'] = Public_token::getMobileExpiration();
        }
        $this->public_token->insert($data);
        return $data['token'];
    }

    /**
     * Check if the post body contains a tablet key
     * If it does it checks the key with the key defined in the config files
     *
     * If the keys are not the same it sends an unauthorized message,
     * if a wrong key is given there is probably someone trying to get authenticated as tablet without being one
     *
     * @return bool | true if the keys are the same
     *              | false if there is no key in the post
     */
    private function _isTablet(){
        if(!$key = $this->input->post('dedicated_key'))
            return false;

        if($key == $this->config->item('tablet_key'))
            return true;

        $this->_throwError('403', ERROR_DONT_MESS_WITH_KEY);
    }

    /**
     * Check if there are other tablets authenticated on the given screen
     * and remove them from the database
     * Only 1 tablet allowed
     *
     * @param $screen_id the screen id
     */
    private function _RemoveOthersOnScreen($screen_id)
    {
        $this->load->model('public_token');
        $tokens = $this->public_token->get_by_screen_id($screen_id);
        foreach($tokens as $token){
            if($token->role == AUTH_TABLET)
                $this->public_token->delete($token->id);
        }
    }

    /**
     * Create a new entry in the admin_tokens table and return the newly created token
     *
     * @param $user the users database info
     * @return mixed the created token
     */
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
