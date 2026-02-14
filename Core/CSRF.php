<?php

/**
 * CSRF Protection
 * 
 * Simple session-based CSRF token generation and validation
 * Protects against Cross-Site Request Forgery attacks
 */

class CSRF {

    /**
     * GenerateToken
     *
     * Generates a new CSRF token and stores it in session
     * 
     * @return string CSRF token
     */
    public static function GenerateToken()
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
     * GetToken
     *
     * Gets the current CSRF token, generating one if it doesn't exist
     * 
     * @return string CSRF token
     */
    public static function GetToken()
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
        return self::GenerateToken();
    }

    /**
     * ValidateToken
     *
     * Validates a CSRF token against the session token
     * 
     * @param string $token Token to validate
     * @return bool True if valid, false otherwise
     */
    public static function ValidateToken($token)
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
     * ValidateRequest
     *
     * Validates CSRF token from POST/GET request
     * Throws exception if invalid
     * 
     * @throws Exception If token is invalid or missing
     * @return bool True if valid
     */
    public static function ValidateRequest()
    {
        // Get token from request
        $token = null;
        if (isset($_POST['csrf_token'])) {
            $token = $_POST['csrf_token'];
        } else if (isset($_GET['csrf_token'])) {
            $token = $_GET['csrf_token'];
        } else if (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            // Support for AJAX requests
            $token = $_SERVER['HTTP_X_CSRF_TOKEN'];
        }
        
        // Validate token
        if (!$token || !self::ValidateToken($token)) {
            // Log security event
            if (class_exists('Logger')) {
                Logger::SecurityEvent('Invalid CSRF token in request');
            }
            throw new Exception('Invalid or missing CSRF token. Please refresh the page and try again.');
        }
        
        return true;
    }

    /**
     * GetTokenField
     *
     * Returns HTML hidden input field with CSRF token
     * 
     * @return string HTML input field
     */
    public static function GetTokenField()
    {
        $token = self::GetToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    /**
     * GetTokenMeta
     *
     * Returns HTML meta tag with CSRF token (for AJAX requests)
     * 
     * @return string HTML meta tag
     */
    public static function GetTokenMeta()
    {
        $token = self::GetToken();
        return '<meta name="csrf-token" content="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
