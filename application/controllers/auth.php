<?php

/**
 * FlatTurtle bvba
 * Authors: gbostoen, Michiel Vancoillie
 */
class Auth extends MY_Controller {

    /**
     * The POST method to authorize as mobile (smartphone / tablet)
     *
     * HTTP method: POST
     * POST vars:   'pin': 'a pincode'
     * Roles allowed: All
     * Url: example.com/auth/mobile
     */
    function mobile_post() {
        // no pin parameter in POST -> 400 bad request
        if (!$pin = $this->input->post('pin'))
            $this->_throwError('400', ERROR_NO_PIN);

        // pincode not numeric -> 400 bad request
        if (!is_numeric($pin))
            $this->_throwError('400', ERROR_PIN_NOT_NUM);

        try {
            $infoscreen = $this->infoscreen->get_by_pin($pin);
        } catch (ErrorException $e) {
            $this->_handleDatabaseException($e);
        }

        // no screen with that pincode -> 403 unauthorized
        if (count($infoscreen) < 1)
            $this->_throwError('403', ERROR_WRONG_PIN);

        $this->load->model('public_token');
        if ($this->public_token->count() > TOKEN_TABLE_LIMIT) {
            $this->public_token->delete_expired();
        }

        if ($token = $this->input->post('token'))
            $this->_deletePublicTokenIfExists($token);

        try {
            $token = $this->_storePublicToken($infoscreen[0]->id);
        } catch (ErrorException $e) {
            $this->_handleDatabaseException($e);
        }

        $this->output->set_output(json_encode($token));
    }

    /**
     * Get alias from PIN
     */
    function alias_post(){
        // no pin parameter in POST -> 400 bad request
        if (!$pin = $this->input->post('pin'))
            $this->_throwError('400', ERROR_NO_PIN);

        // pincode not numeric -> 400 bad request
        if (!is_numeric($pin))
            $this->_throwError('400', ERROR_PIN_NOT_NUM);

        try {
            $infoscreen = $this->infoscreen->get_by_pin($pin);
        } catch (ErrorException $e) {
            $this->_handleDatabaseException($e);
        }

        // no screen with that pincode -> 403 unauthorized
        if (count($infoscreen) < 1)
            $this->_throwError('403', ERROR_WRONG_PIN);

        $this->output->set_output(json_encode($infoscreen[0]->alias));
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
    function admin_post() {
        // no username in post -> bad request
        if (!$username = $this->input->post('username'))
            $this->_throwError('400', ERROR_NO_USERNAME);

        // no password in post -> bad request
        if (!$password = $this->input->post('password'))
            $this->_throwError('400', ERROR_NO_PASSWORD);

        $this->load->model('user');
        $userRow = $this->user->get_by_username($username);

        // no user found with that username -> forbidden
        if (count($userRow) < 1)
            $this->_throwError('403', ERROR_WRONG_USERNAME_PASSWORD);

        $this->load->library('phpass_lib');
        if (!$this->phpass_lib->checkPassword($password, $userRow[0]->password))
            $this->_throwError("403", ERROR_WRONG_USERNAME_PASSWORD);

        $this->load->model('user_token');
        if ($this->user_token->count() > TOKEN_TABLE_LIMIT) {
            $this->user_token->delete_expired();
        }
        // if user already had a token remove it from the database
        if ($token = $this->input->post('token')) {
            $dbtokens = $this->user_token->get_by_token($token);
            if (count($dbtokens) == 1) {
                $this->user_token->delete($dbtokens[0]->id);
            }
        }

        $token = $this->_storeUserToken($userRow[0]);
        $this->output->set_output(json_encode($token));
    }

    /**
     * If user already had a token remove it from the database
     *
     * @param $token
     */
    private function _deletePublicTokenIfExists($token) {
        $dbtokens = $this->public_token->get_by_token($token);
        if (count($dbtokens) == 1) {
            $this->public_token->delete($dbtokens[0]->id);
        }
    }

    /**
     * Create a new entry in the user_tokens table and return the newly created token
     *
     * @param $screen_id the screen that the new token references
     * @return mixed the newly created token
     */
    private function _storePublicToken($screen_id) {
        $data['token'] = sha1(time() . uniqid('', true));
        $data['infoscreen_id'] = $screen_id;
        $data['user_agent'] = $this->input->user_agent();
        $data['ip'] = $this->input->ip_address();

        $this->_removeOthersOnScreen($screen_id);
        $data['role'] = AUTH_TABLET;
        $data['expiration'] = Public_token::getTabletExpiration();

        $this->public_token->insert($data);
        return $data['token'];
    }

    /**
     * Check if there are other tablets authenticated on the given screen
     * and remove them from the database
     * Only 1 tablet allowed
     *
     * @param $screen_id the screen id
     */
    private function _removeOthersOnScreen($screen_id) {
        $this->load->model('public_token');
        $tokens = $this->public_token->get_by_infoscreen_id($screen_id);
        foreach ($tokens as $token) {
            if ($token->role == AUTH_TABLET)
                $this->public_token->delete($token->id);
        }
    }

    /**
     * Create a new entry in the user_tokens table and return the newly created token
     *
     * @param $user the users database info
     * @return mixed the created token
     */
    private function _storeUserToken($user) {
        $data['token'] = sha1(time() . uniqid('', true));
        $data['user_agent'] = $this->input->user_agent();
        $data['ip'] = $this->input->ip_address();
        $data['expiration'] = User_token::getUserExpiration();
        $data['user_id'] = $user->id;
        try {
            $this->user_token->insert($data);
        } catch (ErrorException $e) {
            $this->_handleDatabaseException($e);
        }

        return $data['token'];
    }

}