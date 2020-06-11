<?php

class Strings {
    public static function IfStringStartsWith($key, $query)
    {
        $query_lenght = strlen($query);
        $key_lenght = strlen($key);
        if (substr($key, 0, $query_lenght) === $query)
          return substr($key, $query_lenght, $key_lenght);
        return false;
    }

    public static function GenerateAbstractForPost($input, $lenght = 500, $allowed_tags = null)
    {
        // TODO : bug : question mark at the end of the string for persian characters
        // mb_internal_encoding('UTF-8');     
        // return mb_substr(strip_tags($input, $allowed_tags), 0, $lenght, "UTF-8") . " ...";
        return
        (substr(strip_tags($input, $allowed_tags), 0, $lenght) .
        ((strlen($input) > $lenght) ?
        " ..." :
        "")
        );
    }
}

?>