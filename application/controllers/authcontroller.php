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
        // if user already had a token remove it from the database
        if($token = $this->input->post('token')){
            $dbtokens = $this->public_token->get_by_token($token);
            if(count($dbtokens) == 1){
                $this->public_token->delete($dbtokens[0]->id);
            }
        }

        try{
            $token = $this->_storeToken($pin, $infoscreen[0]->id);
        }catch(ErrorException $e){
            $this->_handleDatabaseException($e);
        }
        $this->output->set_output(json_encode($token));
    }

    private function _storeToken($pin, $screen_id){
        $data['token'] = sha1(time() . uniqid('', true));
        $data['screen_id'] = $screen_id;
        $data['user_agent'] = $this->input->user_agent();
        $data['ip'] = $this->input->ip_address();
        if($this->_isTabletPin($pin)){
            $data['role'] = AUTH_TABLET;
            $data['expiration'] = Public_token::getTabletExpiration();
        }else{
            $data['role'] = AUTH_MOBILE;
            $data['expiration'] = Public_token::getMobileExpiration();
        }
        $this->public_token->insert($data);
        return $data['token'];
    }

    // TODO determine if the pin is used by a tablet (only needed when mobile apps are made to connect with the screens)
    private function _isTabletPin($pin){
        return true;
    }

    /*
     * give access to admin
     */
    function auth_login_post()
    {
        //give admin access with token
    }
}
