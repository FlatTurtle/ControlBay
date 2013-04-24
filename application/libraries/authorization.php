<?php
/**
 * An authorisation library to authorize for a specific role
 *
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Authorization
{
    public $role;
    public $alias;
    public $user_id;

    /**
     * Check if a request is authorized
     *
     * @param $rolesToEnforce the roles that are allowed
     * @return true if the authorization is successful
     */
    function authorize($rolesToEnforce){
        $ci =& get_instance();
        if(!$token = $ci->input->get_request_header('Authorization'))
            $this->_throwError('400', ERROR_NO_TOKEN_IN_AUTHORIZATION);

        $ci->load->model('public_token');
        $ci->load->model('user_token');
        $ci->load->model('user');
        if(!$dbtoken = $ci->public_token->get_by_token($token))
            if(!$dbtoken = $ci->user_token->get_by_token($token))
                $this->_throwError('403', ERROR_INVALID_TOKEN);

        $dbtoken = $dbtoken[0];
        $user = $ci->user->get($dbtoken->user_id);

        if($user[0]->rights == 100){
            // Superadmin user
            $this->user_id = $dbtoken->user_id;
            $this->role = AUTH_SUPER_ADMIN;
            return true;
        }else{
            // Regular users
            if( $dbtoken->expiration < date('Y-m-d H:i:s', time()) ||
                $dbtoken->ip != $ci->input->ip_address() ||
                $dbtoken->user_agent != $ci->input->user_agent())
            {
                try{
                    $ci->public_token->delete($dbtoken->id);
                }catch(ErrorException $e){
                    log_message("Database error: " . $e);
                }
                $this->_throwError('403', ERROR_INVALID_TOKEN);
            }

            if(isset($dbtoken->infoscreen_id)){
                $infoscreen = $ci->infoscreen->get($dbtoken->infoscreen_id);
                if(count($infoscreen) == 1)
                    $this->alias = $infoscreen[0]->alias;
                else
                    $this->_throwError('403', ERROR_INVALID_TOKEN);
    			$this->role = $dbtoken->role;
            }else{
                $this->user_id = $dbtoken->user_id;
    			$this->role = AUTH_ADMIN;
            }

            if(!$this->correctRole($this->role, $rolesToEnforce))
                $this->_throwError('401', ERROR_ROLE);

            // Proper return for tablets
            if(!empty($this->alias))
                return $this->alias;
            else
                return true;
        }
    }

    /**
     * Check if the user has the right role
     *
     * @param $userRole the role of the user
     * @param $rolesToEnforce the allowed roles
     * @return bool true if the user has the right role
     *              false if the user has the wrong role
     */
    function correctRole($userRole, $rolesToEnforce){
        if(!is_array($rolesToEnforce))
            $rolesToEnforce = array($rolesToEnforce);

        foreach($rolesToEnforce as $role){
            if($role == $userRole)
                return true;
        }
        return false;
    }

    private function _throwError($code, $message){
        $ci =& get_instance();
        $ci->output->set_status_header($code);
        echo $message;
        exit;
    }
}
