<?php

/**
 * © 2012 FlatTurtle bvba
 * Author: Michiel Vancoillie
 * Licence: AGPLv3
 */
class API_Base extends MY_Controller {

    /**
     * Validate a request and return infoscreen from alias
     */
    protected function validate_and_get_infoscreen($roles, $alias) {
        $response = $this->authorization->authorize($roles);

        // Get alias for tablets
        if(!is_bool($response)){
            $alias = $response;
        }

        if (!$infoscreen = $this->infoscreen->get_by_alias($alias))
            $this->_throwError('404', ERROR_NO_INFOSCREEN);

        // Check ownership
        if (!$this->infoscreen->isOwner($alias))
            $this->_throwError('401', ERROR_NO_OWNERSHIP_SCREEN);

        return $infoscreen[0];
    }

}