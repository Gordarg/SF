<?php

namespace SF\Libs;

/**
 * Input Validator
 * 
 * Provides common input validation and sanitization functions
 * Helps prevent XSS, SQL injection, and other input-based attacks
 */
class Validator
{

    /**
     * sanitizeString
     *
     * Sanitizes a string input by removing HTML tags and special characters
     * 
     * @param string $input Input string
     * @return string Sanitized string
     */
    public static function sanitizeString($input)
    {
        if (!is_string($input)) {
            return '';
        }
        
        // Remove HTML and PHP tags
        $input = strip_tags($input);
        
        // Trim whitespace
        $input = trim($input);
        
        return $input;
    }

    /**
     * sanitizeHtml
     *
     * Sanitizes HTML input (for cases where some HTML is allowed)
     * Only allows safe tags
     * 
     * @param string $input Input string
     * @return string Sanitized HTML
     */
    public static function sanitizeHtml($input)
    {
        if (!is_string($input)) {
            return '';
        }
        
        // Allow only safe HTML tags
        $allowedTags = '<p><br><strong><em><u><a><ul><ol><li><blockquote><code><pre><h1><h2><h3><h4><h5><h6>';
        
        return strip_tags($input, $allowedTags);
    }

    /**
     * escapeOutput
     *
     * Escapes output for safe HTML rendering
     * 
     * @param string $output Output string
     * @return string Escaped string
     */
    public static function escapeOutput($output)
    {
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }

    /**
     * validateEmail
     *
     * Validates email address format
     * 
     * @param string $email Email address
     * @return bool True if valid, false otherwise
     */
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * validateInteger
     *
     * Validates integer input
     * 
     * @param mixed $input Input value
     * @return int|false Integer value or false if invalid
     */
    public static function validateInteger($input)
    {
        return filter_var($input, FILTER_VALIDATE_INT);
    }

    /**
     * validateUrl
     *
     * Validates URL format
     * 
     * @param string $url URL string
     * @return bool True if valid, false otherwise
     */
    public static function validateUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * sanitizeFilename
     *
     * Sanitizes filename to prevent directory traversal
     * 
     * @param string $filename Filename
     * @return string Sanitized filename
     */
    public static function sanitizeFilename($filename)
    {
        // Remove directory separators and null bytes
        $filename = str_replace(['/', '\\', "\0"], '', $filename);
        
        // Remove leading dots to prevent hidden files
        $filename = ltrim($filename, '.');
        
        return $filename;
    }

    /**
     * validateLength
     *
     * Validates string length
     * 
     * @param string $input Input string
     * @param int $min Minimum length
     * @param int $max Maximum length
     * @return bool True if valid, false otherwise
     */
    public static function validateLength($input, $min = 0, $max = PHP_INT_MAX)
    {
        $length = mb_strlen($input, 'UTF-8');
        return $length >= $min && $length <= $max;
    }

    /**
     * sanitizeArray
     *
     * Recursively sanitizes array values
     * 
     * @param array $array Input array
     * @return array Sanitized array
     */
    public static function sanitizeArray($array)
    {
        if (!is_array($array)) {
            return [];
        }
        
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = self::sanitizeArray($value);
            } else {
                $array[$key] = self::sanitizeString($value);
            }
        }
        
        return $array;
    }

    /**
     * validateCsrfToken
     *
     * Validates CSRF token using the CSRF class
     * 
     * @param string $token Token to validate
     * @return bool True if valid, false otherwise
     */
    public static function validateCsrfToken($token)
    {
        // Delegate to CSRF class for validation
        if (class_exists('CSRF')) {
            return CSRF::ValidateToken($token);
        }
        
        // Fallback if CSRF class not loaded
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
