<?php

/**
 * Input Validator
 * 
 * Provides common input validation and sanitization functions
 * Helps prevent XSS, SQL injection, and other input-based attacks
 */

class Validator {

    /**
     * SanitizeString
     *
     * Sanitizes a string input by removing HTML tags and special characters
     * 
     * @param string $input Input string
     * @return string Sanitized string
     */
    public static function SanitizeString($input)
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
     * SanitizeHTML
     *
     * Sanitizes HTML input (for cases where some HTML is allowed)
     * Only allows safe tags
     * 
     * @param string $input Input string
     * @return string Sanitized HTML
     */
    public static function SanitizeHTML($input)
    {
        if (!is_string($input)) {
            return '';
        }
        
        // Allow only safe HTML tags
        $allowedTags = '<p><br><strong><em><u><a><ul><ol><li><blockquote><code><pre><h1><h2><h3><h4><h5><h6>';
        
        return strip_tags($input, $allowedTags);
    }

    /**
     * EscapeOutput
     *
     * Escapes output for safe HTML rendering
     * 
     * @param string $output Output string
     * @return string Escaped string
     */
    public static function EscapeOutput($output)
    {
        return htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    }

    /**
     * ValidateEmail
     *
     * Validates email address format
     * 
     * @param string $email Email address
     * @return bool True if valid, false otherwise
     */
    public static function ValidateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * ValidateInteger
     *
     * Validates integer input
     * 
     * @param mixed $input Input value
     * @return int|false Integer value or false if invalid
     */
    public static function ValidateInteger($input)
    {
        return filter_var($input, FILTER_VALIDATE_INT);
    }

    /**
     * ValidateURL
     *
     * Validates URL format
     * 
     * @param string $url URL string
     * @return bool True if valid, false otherwise
     */
    public static function ValidateURL($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * SanitizeFilename
     *
     * Sanitizes filename to prevent directory traversal
     * 
     * @param string $filename Filename
     * @return string Sanitized filename
     */
    public static function SanitizeFilename($filename)
    {
        // Remove directory separators and null bytes
        $filename = str_replace(['/', '\\', "\0"], '', $filename);
        
        // Remove leading dots to prevent hidden files
        $filename = ltrim($filename, '.');
        
        return $filename;
    }

    /**
     * ValidateLength
     *
     * Validates string length
     * 
     * @param string $input Input string
     * @param int $min Minimum length
     * @param int $max Maximum length
     * @return bool True if valid, false otherwise
     */
    public static function ValidateLength($input, $min = 0, $max = PHP_INT_MAX)
    {
        $length = mb_strlen($input, 'UTF-8');
        return $length >= $min && $length <= $max;
    }

    /**
     * SanitizeArray
     *
     * Recursively sanitizes array values
     * 
     * @param array $array Input array
     * @return array Sanitized array
     */
    public static function SanitizeArray($array)
    {
        if (!is_array($array)) {
            return [];
        }
        
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = self::SanitizeArray($value);
            } else {
                $array[$key] = self::SanitizeString($value);
            }
        }
        
        return $array;
    }

    /**
     * ValidateCSRFToken
     *
     * Validates CSRF token (placeholder for CSRF implementation)
     * 
     * @param string $token Token to validate
     * @return bool True if valid, false otherwise
     */
    public static function ValidateCSRFToken($token)
    {
        // This will be implemented when CSRF protection is added
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
