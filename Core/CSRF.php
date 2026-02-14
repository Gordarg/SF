<?php

namespace SF\Core;

/**
 * CSRF Protection
 * 
 * Simple session-based CSRF token generation and validation
 * Protects against Cross-Site Request Forgery attacks
 */
class CSRF
{
    /**
     * Generates a new CSRF token and stores it in session
     * 
     * @return string CSRF token
     */
    public static function generateToken(): string
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Generate a random token
        if (function_exists('random_bytes')) {
            $token = bin2hex(random_bytes(32));
        } else {
            // Fallback for older PHP versions
            $token = bin2hex(openssl_random_pseudo_bytes(32));
        }
        
        // Store token in session
        $_SESSION['csrf_token'] = $token;
        $_SESSION['csrf_token_time'] = time();
        
        return $token;
    }

    /**
     * getToken
     *
     * Gets the current CSRF token, generating one if it doesn't exist
     * 
     * @return string CSRF token
     */
    public static function getToken()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if token exists and is not expired (valid for 1 hour)
        if (isset($_SESSION['csrf_token']) && 
            isset($_SESSION['csrf_token_time']) &&
            (time() - $_SESSION['csrf_token_time']) < 3600) {
            return $_SESSION['csrf_token'];
        }
        
        // Generate new token if doesn't exist or expired
        return self::generateToken();
    }

    /**
     * validateToken
     *
     * Validates a CSRF token against the session token
     * 
     * @param string $token Token to validate
     * @return bool True if valid, false otherwise
     */
    public static function validateToken($token)
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if token exists in session
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        
        // Check if token is expired (valid for 1 hour)
        if (!isset($_SESSION['csrf_token_time']) || 
            (time() - $_SESSION['csrf_token_time']) >= 3600) {
            return false;
        }
        
        // Use hash_equals to prevent timing attacks
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * validateRequest
     *
     * Validates CSRF token from POST/GET request
     * Throws exception if invalid
     * 
     * @throws Exception If token is invalid or missing
     * @return bool True if valid
     */
    public static function validateRequest()
    {
        // Get token from request
        $token = null;
        if (isset($_POST['csrf_token'])) {
            $token = $_POST['csrf_token'];
        } elseif (isset($_GET['csrf_token'])) {
            $token = $_GET['csrf_token'];
        } elseif (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            // Support for AJAX requests
            $token = $_SERVER['HTTP_X_CSRF_TOKEN'];
        }
        
        // Validate token
        if (!$token || !self::validateToken($token)) {
            // Log security event
            if (class_exists('Logger')) {
                Logger::SecurityEvent('Invalid CSRF token in request');
            }
            throw new Exception('Invalid or missing CSRF token. Please refresh the page and try again.');
        }
        
        return true;
    }

    /**
     * getTokenField
     *
     * Returns HTML hidden input field with CSRF token
     * 
     * @return string HTML input field
     */
    public static function getTokenField()
    {
        $token = self::getToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    /**
     * getTokenMeta
     *
     * Returns HTML meta tag with CSRF token (for AJAX requests)
     * 
     * @return string HTML meta tag
     */
    public static function getTokenMeta()
    {
        $token = self::getToken();
        return '<meta name="csrf-token" content="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
