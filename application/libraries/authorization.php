<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */
class Authorization
{
    public $role;
    public $host;
    public $isAuthorized = false;

    function authorize($rolesToEnforce){
        $ci =& get_instance();
        if(!$token = $ci->input->get_request_header('Authorization'))
            $this->_throwUnauthorized();

        //TODO differentiate between public tokens and admin tokens
        $ci->load->model('public_token');
        $ci->load->model('admin_token');
        if(!$dbtoken = $ci->public_token->get_by_token($token))
            if(!$dbtoken = $ci->admin_token->get_by_token($token))
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

        if(isset($dbtoken->screen_id)){
            $ci->load->model('infoscreen');
            $infoscreen = $ci->infoscreen->get($dbtoken->screen_id);
            if(count($infoscreen) == 1)
                $this->host = $infoscreen[0]->hostname;
            else
                $this->_throwUnauthorized();

        }
        $this->role = $dbtoken->role;

        if(!$this->correctRole($this->role, $rolesToEnforce))
            $this->_throwUnauthorized();

        $this->isAuthorized = true;
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
