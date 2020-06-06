<?php

/**
 * 
 * Class in common between Controllers and ApiControllers
 * Handling authentication and authorization
 * 
 */

class Auth {

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
        // Check cookies
        if (!isset($Data['Email'], $Data['UserId']))
        {
            throw new AuthException("شناسه کاربری یافت نشد");
            exit;
        }
        
        // Connect to the model
        $Model = $this->CallModel("Auth");

        // Check if user is still login
        $CheckSessions = $Model->CheckSessions([
            'Email' => $Data['Email']
        ]);

        // If user was not found in database
        // (regarding to search based on `Id`)
        if (count($CheckSessions) == 0)
        {
            throw new AuthException("شناسه کاربری در پایگاه داده یافت نشد");
            exit;
        }

        // If session not valid
        if ($CheckSessions[0]['LoginStatus'] == 0)
        {
            throw new AuthException("نشست فعال نیست");
            exit;
        }

        return true;
        
    }

}