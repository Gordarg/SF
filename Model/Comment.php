<?php

class Comment extends Model {

    function GetAllComments() {
        $Query = "SELECT Comments.`Id` as 'Id', `EMail`, `Name`
        , SUBSTRING(Comments.Body FROM 1 FOR 100) as Body
        , Posts.`Title`
        , IsPublic, IsVisible
        , YEAR(Comments.`Submit`) 'Year', MONTH(Comments.`Submit`) 'Month', DAY(Comments.`Submit`) 'Day'
        FROM `Comments`
        INNER JOIN `Posts` ON Posts.Id = Comments.PostId
        WHERE `IsDeleted` = 0
        ORDER BY `IsVisible` DESC, Comments.`Id` DESC";
        $Result = $this->DoSelect($Query);
        return $Result;
    }

    function GetCommentById($Values) {
        $Query = "SELECT Comments.`Id`, `EMail`, `Name`
        , Comments.Body
        , Posts.`Title`, Posts.FileName
        , IsPublic, IsVisible
        , Comments.Submit
        FROM `Comments`
        INNER JOIN `Posts` ON Posts.Id = Comments.PostId
        WHERE Comments.Id=:Id";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function InsertNewComment($Values) {
        $Query = "INSERT INTO `Comments` (`Name`, `EMail`, `Body`, `IsPublic`, `IsDeleted`, `IsVisible`, `PostId`) VALUES (:Name, :EMail, :Body, :IsPublic, b'0', b'0', :PostId)";
        var_dump($Values);
        var_dump($Query);
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }

    function GetPostComments($Values) {
        $Query = "SELECT Comments.`Id` as 'Id', `EMail`, `Name`, Body
        , YEAR(Comments.`Submit`) 'Year', MONTH(Comments.`Submit`) 'Month', DAY(Comments.`Submit`) 'Day'
        FROM `Comments`
        WHERE `IsDeleted` = 0 AND `IsVisible` = 1 AND `IsPublic` = 1
        ORDER BY `Id` DESC";
        $Result = $this->DoSelect($Query);
        return $Result;
    }

    function UpdateComment($Values) {
        $Query = "UPDATE `Comments` SET `IsVisible` = :IsVisible, `IsDeleted`=:IsDeleted WHERE `Id`=:Id";
        $Result = $this->DoQuery($Query, $Values);
        return $Result;
    }

    function GroupedCommentCount() {
        $Query = 'SELECT
        CONCAT(\'هفته \', WeekNumber) as WeekNumber,
        COUNT(*) as TotalRequests
        FROM
        (
            SELECT
            DATEDIFF(`Submit`, NOW()) AS WeekNumber
            FROM `Comments`
            WHERE `Submit` > DATE_ADD(NOW(), INTERVAL -90 DAY) -- Limit for three monthes
        ) as AliasOfFirstSelect
        GROUP BY
        WeekNumber';
        $Result = $this->DoSelect($Query);
        return $Result;
    }

}