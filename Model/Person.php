<?php

class Person extends Model {

    function GetAllPeople() {
        $Query = "SELECT `Id`, `Username` FROM `people` ORDER BY `Id`";
        $Result = $this->DoSelect($Query);
        return $Result;
    }

    function UpdatePassword($Values) {
        $Query = 'UPDATE `people` SET `HashPassword` = :Password WHERE `Id`=:Id';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }

    function GetPersonById($Values) {
        $Query = "SELECT `Id`, `Username` FROM `people` WHERE `Id`=:Id LIMIT 1";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

}