<?php
/**
 * © 2012 FlatTurtle bvba
 * Author: Nik Torfs
 * Licence: AGPLv3
 */

    /**
     * this function checks if a role is allowed and exits if the role is not allowed
     *
     * @param $userRole
     * @param $rolesToEnforce
     * @param $output
     */
    function enforceRole($userRole, $rolesToEnforce, $output){
        if(!is_array($rolesToEnforce))
            $rolesToEnforce = array($rolesToEnforce);

        foreach($rolesToEnforce as $role){
            if($role == $userRole){
                return;
            }
        }
        $output->set_status_header('403');
        echo json_encode(ERROR_ROLE);
        exit;
    }

