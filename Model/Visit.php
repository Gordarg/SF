<?php

class Visit extends Model {

    function GroupedVisitCount() {
        $Query = 'SELECT
        CONCAT(\'هفته \', WeekNumber) as WeekNumber,
        COUNT(*) as TotalRequests
        FROM
        (
            SELECT
            DATEDIFF(`Submit`, NOW()) AS WeekNumber
            FROM `visits`
            WHERE `Submit` > DATE_ADD(NOW(), INTERVAL -90 DAY) -- Limit for three monthes
        ) as AliasOfFirstSelect
        GROUP BY
        WeekNumber';
        $Result = $this->DoSelect($Query);
        return $Result;
    }

    function GroupedVisitCountByAgent() {
        $Query = 'SELECT
        COUNT(*) as TotalRequests,
        HTTP_Person_AGENT as Agent
        FROM `visits`
        WHERE `Submit` > DATE_ADD(NOW(), INTERVAL -90 DAY) -- Limit for three monthes
        GROUP BY `HTTP_Person_AGENT`
        ';
        $Result = $this->DoSelect($Query);
        return $Result;
    }

    function PostsVisitCountByAddress() {
        $Query = 'SELECT
        COUNT(*) as TotalRequests,
        REQUEST_URI as Uri
        FROM `visits`
        WHERE `Submit` > DATE_ADD(NOW(), INTERVAL -90 DAY) -- Limit for three monthes
        AND `REQUEST_URI` LIKE \'%HOME/VIEW%\'
        GROUP BY `REQUEST_URI`
        ORDER BY Uri DESC
        ';
        $Result = $this->DoSelect($Query);
        return $Result;
    }
}