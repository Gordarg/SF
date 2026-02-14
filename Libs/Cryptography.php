<?php

namespace SF\Libs;

/**
 * Cryptography utility class
 * 
 * Provides encryption and hashing functions
 */
class Cryptography
{
    private const SALT = 'MyVoiceIsMyPassport';
    
    /**
     * Encrypts the input
     * 
     * @param string $input Input to encrypt
     * @return string Encrypted hash
     */
    public static function encrypt(string $input): string
    {
        return hash('sha512', self::SALT . $input);
    }
}