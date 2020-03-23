<?php

class File extends Model {

    function GetFiles() {
        $Query = 'SELECT `Id`, `FileName`, `Submit` FROM `Files` ORDER BY `Id` DESC';
        $Result = $this->DoSelect($Query);
        return $Result;
    }

    function InsertNewFile($Values) {
        $Query = 'INSERT INTO `Files` (`FileName`, `Submit`) VALUES (:FileName,  NOW())';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }
    
    function GetFile($Values) {
        $Query = 'SELECT `Id`, `FileName`, `Submit` FROM `Files` WHERE `Id`=:Id';
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function DeleteFile($Values) {
        $Query = 'DELETE FROM `Files` WHERE `Id`=:Id';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }


}