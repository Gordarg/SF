<?php

/**
 * 
 * An alternative to model `people`
 * because of Fatal error: Cannot declare class Person, because the name is already in use
 * 
 */

class Authentication extends Model {
    

    function ValidatePersonPass($Values) {
        $Query = "SELECT `Id` FROM `people` WHERE `Username`= :Username and `HashPassword`= :Password";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function CheckSessions($Values) {
        // TODO:
        $Query = "SELECT '1' AS 'LoginStatus' FROM `people` WHERE Username LIKE :Username";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }
}