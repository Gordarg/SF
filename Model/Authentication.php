<?php

/**
 * 
 * An alternative to model `users`
 * because of Fatal error: Cannot declare class User, because the name is already in use
 * 
 */

class Authentication extends Model {
    

    function ValidateUserPass($Values) {
        $Query = "SELECT `Id` FROM `users` WHERE `Username`= :Username and `HashPassword`= :Password";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function CheckSessions($Values) {
        // TODO:
        $Query = "SELECT '1' AS 'LoginStatus' FROM `users` WHERE Username LIKE :Username";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }
}