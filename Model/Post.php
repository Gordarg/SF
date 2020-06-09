<?php

class Post extends Model {

    function GetHomePagePosts() {
        $Query = '
        SELECT `MasterID`, `Id`, `Title`, YEAR(`Submit`) \'Year\',
        MONTH(`Submit`) \'Month\', DAY(`Submit`) \'Day\',
        `Body`, `Username`, `Language` FROM `post_details`
        WHERE Status=\'PUBLISH\'
        ORDER BY `Id` DESC
        ';
        $Result = $this->DoSelect($Query);
        return $Result;
    }

    function GetPostContent($Values) {
        $Query = '
        SELECT `BinContent` FROM `post_details`
        WHERE MasterID=:MasterID AND Language=:Language
        ORDER BY `Id` DESC
        ';
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function GetPost($Values) {
        $Query = '
        SELECT `MasterID`, `Id`, `Title`, YEAR(`Submit`) \'Year\',
        MONTH(`Submit`) \'Month\', DAY(`Submit`) \'Day\',
        `Body`, `Username`, `Language` FROM `post_details`
        WHERE Status=\'PUBLISH\'
        AND MasterID=:MasterID AND Language=:Language
        ORDER BY `Id` DESC
        ';
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function GetAllPosts() {
        $Query = "SELECT `MasterID`, `Id`, `Title`, `Submit`, `Username`, `Status`, `Language` FROM `post_details` ORDER BY `Id` DESC";
        $Result = $this->DoSelect($Query);
        return $Result;
    }

    function InsertPost($Values) {
        $Query = 'INSERT INTO `Posts` (`Title`, `Abstract`, `Body`, `Type`, `FileName`) VALUES (:Title, :Abstract, :Body, :Type, :FileName)';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }
    
    function UpdatePost($Values) {
        $Query = 'UPDATE `Posts` SET `Title` = :Title, `Abstract` = :Abstract, `Body` = :Body, `Type` = :Type, `FileName` = :FileName WHERE `Id`=:Id';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }

    function DeletePost($Values) {
        $Query = 'DELETE FROM `Posts` WHERE `Id`=:Id';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }

    function GetPostById($Values) {
        $Query = "SELECT `Id`, `Title`, `Type`, `FileName`, YEAR(`Submit`) 'Year', MONTH(`Submit`) 'Month', DAY(`Submit`) 'Day', `Abstract`, `Body` FROM `Posts` WHERE `Id`=:Id LIMIT 1";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

}