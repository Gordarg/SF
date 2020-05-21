<?php

class TSQL {
    public static function Execute($Name, $Params, $Result = true){
        $query  = file_get_contents(BASEPATH . "scripts/" . $Name . '.sql');
		for ($i = 0; $i < sizeof($Params); $i++ )
		{
			$query = str_replace("@" . $Params[$i][0], $Params[$i][1], $query);
		}
		$db = new Db();
		$conn = $db->Open();
		$result = mysqli_query($conn, $query);
        if (!$Result)
            return;
		$num = mysqli_num_rows($result);
        $rows = [];
        while(($row = mysqli_fetch_assoc($result))) {
            $rows[] = $row;
		}
		return $rows;
    }
    public static function PreventInjection($input) {
        // TODO:
    }
}