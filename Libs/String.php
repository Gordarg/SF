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
}

?>