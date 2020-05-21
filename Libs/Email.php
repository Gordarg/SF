<?php

class Email {
    public static function ExtractEmails($string){
        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
        return $matches[0];
    }
}