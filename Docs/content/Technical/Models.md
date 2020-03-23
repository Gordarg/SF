# A sample model be like

```
class ModelName extends Model {

    function SelectCommand($Values) {
        $Query = "SELECT * FROM `X WHERE `A`= :A";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

    function InsertCommand($Values) {
        $Query = "INSERT INTO X Values(:A)";
        $Result = $this->DoSelect($Query, $Values);
        return $Result;
    }

}
```