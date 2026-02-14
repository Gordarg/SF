<?php

namespace SF\Libs;

/**
 * Cryptography utility class
 * 
 * Provides encryption and hashing functions
 * 
 * SECURITY WARNING: Change the SALT value in production!
 * The default salt should be replaced with a unique value
 * in your Config.php or environment variables.
 */
class Cryptography
{
    // TODO: Move to Config.php and use environment variable
    // Example: private const SALT = _CryptoSalt;
    private const SALT = 'MyVoiceIsMyPassport';
    
    /**
     * Encrypts the input
     * 
     * @param string $input Input to encrypt
     * @return string Encrypted hash
     */
    public static function encrypt(string $input): string
    {
        // Use configured salt if available, otherwise fallback to default
        $salt = defined('_CryptoSalt') ? _CryptoSalt : self::SALT;
        return hash('sha512', $salt . $input);
    }
}