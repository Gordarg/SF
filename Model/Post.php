<?php

class Post extends Model {

    function GetHomePagePosts() {
        $Query = '
        SELECT `MasterId`, `Id`, `Title`, YEAR(`Submit`) \'Year\',
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
        WHERE MasterId=:MasterId AND Language=:Language
        ORDER BY `Id` DESC
        ';
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function GetPost($Values) {
        $Query = '
        SELECT `MasterId`, `Id`, `Title`, YEAR(`Submit`) \'Year\',
        MONTH(`Submit`) \'Month\', DAY(`Submit`) \'Day\',
        `Body`, `Username`, `Language` FROM `post_details`
        WHERE Status=\'PUBLISH\'
        AND MasterId=:MasterId AND Language=:Language
        ORDER BY `Id` DESC
        ';
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function GetAllPosts($Values) {
        $Query = "SELECT `MasterId`, `Id`, `Title`, `Submit`, `UserId`, `Username`, `Status`, `Language`
        FROM `post_details`
        ORDER BY `Id` DESC
        limit :From, :To
        ";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function InsertPost($Values) {
        $Query = '
        INSERT INTO `posts` (
        MasterId, Title, BinContent, Body, UserId, `Status`, Language
        ) VALUES (
        :MasterId, :Title, :BinContent, :Body, :UserId, :Status, :Language
        );';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }
    
    function UpdatePost($Values) {
        $Query = '
        INSERT INTO `posts` (
        MasterId, Title, BinContent, Body, UserId, `Status`, Language, IsContentDeleted
        ) VALUES (
        :MasterId, :Title, :BinContent, :Body, :UserId, :Status, :Language, :IsContentDeleted
        );
        ';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }

    function DeletePost($Values) {
        $Query = '
        INSERT INTO `posts` (
        MasterId, Title, Body, UserId, `Status`, Language, IsDeleted
        ) VALUES (
        :MasterId, :Title, :Body, :UserId, \'DELETE\', :Language, true
        );
        ';
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }

    function DeletePostContent($Values) {
        // TODO:
    }

    function GetPostById($Values) {
        $Query = "SELECT `MasterId`, `Id`, `Title`, `Submit`,
        `Body`, `UserId`, `Language`, `IsContentDeleted`, `IsDeleted` FROM `posts` WHERE `Id`=:Id LIMIT 1";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function GetPostByMasterId($Values) {
        $Query = "SELECT `MasterId`, `Id`, `Title`, `Submit`,
        `Body`, `UserId`, `Username`, `Language` FROM `post_details` WHERE `MasterId`=:MasterId LIMIT 1";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

}