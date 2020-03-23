<?php

/**
 * This class handles functionality around cryptography, hashing, encryption, and etc...
 */

class Cryptography {
        
    /**
     * Encrypt
     *
     * Encrypts the input
     * 
     * @return String
     */
    public static function Encrypt($input) {
        return md5($input);
    }
}