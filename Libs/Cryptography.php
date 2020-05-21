<?php

/**
 * This class handles functionality around cryptography, hashing, encryption, and etc...
 */

class Cryptography {
    const SALT = 'MyVoiceIsMyPassport';
    /**
     * Encrypt
     *
     * Encrypts the input
     * 
     * @return String
     */
    public static function Encrypt($input) {
        return hash('sha512', self::SALT . $input);
    }
}

?>