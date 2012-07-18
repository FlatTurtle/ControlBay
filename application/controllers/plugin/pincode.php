<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */

class Pincode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if its executed from cronjob
        if(defined('ENVIRONMENT')){
            switch (ENVIRONMENT)
            {
                case 'development':
                    break;
                default:
                    if(!(php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR']))) {
                        show_error('not on CLI');
                    }
                    break;
            }
        }
    }

    function refresh_pin($host)
    {
        //adapt the database
        $new = false;
        $pin = 0;
        while($new == false){
            $pin = rand(111111, 999999);
            $this->load->model('Infoscreen');
            if(!$query = $this->Infoscreen->get_by_pin($pin))
                $new = true;
        }

        $result = $this->Infoscreen->get_by_hostname($host);
        if($result != 0){
            $this->Infoscreen->edit($result[0]->id,array("pincode" => $pin));
            //reload hostscreen
            $this->xmpp_lib->sendMessage($host, 'Pincode.add(\''.$pin.'\');');
        }
    }
}
