<?php

/**
 * 
 * Class in common between Controllers and ApiControllers
 * Handling authentication and authorization
 * 
 */

class Auth {

    protected $ParentController;

    function __construct($ParentController) {
        $this->ParentController = $ParentController;
    }

    /**
     * CheckLogin
     *
     * Checks the user role and login
     * 
     * @param  mixed $Data
     * @param  mixed $Role
     *
     * @return void
     */
    function CheckLogin($Data, $Role = 'admin')
    {

        // TODO: Check sessions

        return true;
        
    }

}