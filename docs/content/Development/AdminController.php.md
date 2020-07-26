# Interpreter

For MVC API, we do not generate server-side views;
instead, we use static files located in /gui to
generate htm views in client-side using jquery.

The process above needs a canvas that we use InterpreterGET()
as the canvas.

Each item has a *.js* file and a *.htm* file that
the *js* handles the functionality and *.htm* handles
the content.

# CRUD

This allows us to rapidly generate crud for any model
which follows the template below:

```
function DescribeTable() {
    return $this->DoSelect('DESCRIBE TABLENAMEHERE');
}
function GetAdminPanelItems($Values = null) {
    $Query = 'SELECT
    CONCAT(\'<a class="btn btn-sm btn-default" href="' . _Root . 'Admin/CRUD/MODELNAMEHERE/\', id , \'">\', \'Edit\', \'</a>\') as Edit,
    Id
    ,Title
    ,Submit
    FROM TABLENAMEHERE
    ORDER BY Id ASC';
    return $this->DoSelect($Query);
}
function GetItemByIdentifier($Values) {
    $Query = "SELECT *
    FROM TABLENAMEHERE
    WHERE Id = :Id
    LIMIT 1";
    return $this->DoSelect($Query, $Values);
}
```