<?php

/**
 * 
 * An alternative to model `users`
 * because of Fatal error: Cannot declare class User, because the name is already in use
 * 
 */

class Session extends Model {
    
    function CheckSessions($Values) {
        // TODO:
        $Query = "SELECT '1' AS 'LoginStatus' FROM `users` WHERE Username LIKE :Username";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }
}