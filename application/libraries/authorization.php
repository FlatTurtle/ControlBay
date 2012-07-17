<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Authorization
{
    var $role;

    function authorize($userRole, $rolesToEnforce){
        $ci =& get_instance();
        if(!$token = $ci->input->get_request_header('Authorization'))
            $this->_throwUnauthorized();

        //TODO differentiate between public tokens and admin tokens
        $ci->load->model('public_token');
        if(!$dbtoken = $ci->public_token->get_by_token($token))
            $this->_throwUnauthorized();

        $dbtoken = $dbtoken[0];
        if( $dbtoken->expiration < date('Y-m-d H:i:s', time()) ||
            $dbtoken->ip != $ci->input->ip_address() ||
            $dbtoken->user_agent != $ci->input->user_agent())
        {
            try{
                $ci->public_token->delete($dbtoken->id);
            }catch(ErrorException $e){
                log_message("Database error: " . $e);
            }
            $this->_throwUnauthorized();
        }

        $ci->load->model('infoscreen');
        $infoscreen = $ci->infoscreen->get($dbtoken->screen_id);
        if(count($infoscreen) == 1){
            $_POST['host'] = $infoscreen[0]->hostname;
        }else
            $this->_throwUnauthorized();

        if(!$this->correctRole($dbtoken->role, $rolesToEnforce))
            $this->_throwUnauthorized();
    }

    function correctRole($userRole, $rolesToEnforce){
        if(!is_array($rolesToEnforce))
            $rolesToEnforce = array($rolesToEnforce);

        foreach($rolesToEnforce as $role){
            if($role == $userRole)
                return true;
        }
        return false;
    }

    private function _throwUnauthorized(){
        $ci =& get_instance();
        $ci->output->set_status_header('403');
        echo json_encode(ERROR_ROLE);
        exit;
    }
}
