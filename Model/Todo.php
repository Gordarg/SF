<?php

class Todo extends Model {


    // === Based on a template ===
    function DescribeTable() {
        return $this->DoSelect("DESCRIBE `Todos`");
    }
    function GetAdminPanelItems($Values = null) {

        $Query = 'SELECT
        CONCAT(\'<a class="btn btn-sm btn-default" href="' . _Root . 'My/CRUD/Todo/\', id , \'">\', \'Edit\', \'</a>\') as Edit,
        Id
        ,`Title`
        ,`Submit`
        FROM `Todos`
        ORDER BY `Id` ASC';

        return $this->DoSelect($Query);
    }
    function GetItemByIdentifier($Values) {
        $Query = "SELECT *
        FROM `Todos`
        WHERE `Id` = :Id
        LIMIT 1";

        return $this->DoSelect($Query, $Values);
    }
}
?>