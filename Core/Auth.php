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


        $Values = [
            'Username' => $Data['Username'],
            'Password' => (new Cryptography())->Encrypt($Data['Password'])
        ];

        $Model = $this->ParentController->CallModel('Authentication');
        $Entity = $Model->ValidateUserPass($Values);

        // TODO: Check sessions

        return (count($Entity) == 1);
        
    }

}