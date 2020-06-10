<?php

class User extends Model {

    function GetAllUsers() {
        $Query = "SELECT `Id`, `Username` FROM `users` ORDER BY `Id`";
        $Result = $this->DoSelect($Query);
        return $Result;
    }

    function UpdatePassword($Values) {
        $Query = 'UPDATE `users` SET `HashPassword` = :Password WHERE `Id`=:Id';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }

    function GetUserById($Values) {
        $Query = "SELECT `Id`, `Username` FROM `users` WHERE `Id`=:Id LIMIT 1";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

}