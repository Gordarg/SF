<?php

class Arrays{
    public static function IfExists($varname)
    {
        return(isset($$varname)?$varname:null);
    }
    public static function IfExistsIndexInArray($var,$index)
    {
        return(isset($var[$index])?$var[$index]:null);
    }
}

?>