<?php

/**
 * Security Headers
 * 
 * Centralizes security header management for the application
 * Implements defense-in-depth security measures
 */

class SecurityHeaders {

    /**
     * SetSecurityHeaders
     *
     * Sets all security-related HTTP headers
     * 
     * @return void
     */
    public static function SetSecurityHeaders()
    {
        // Content Security Policy - Restricts resource loading
        // This is a permissive policy that allows the app to function
        // while still providing XSS protection
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:; connect-src 'self';");
        
        // Prevent clickjacking attacks
        header("X-Frame-Options: DENY");
        
        // Prevent MIME type sniffing
        header("X-Content-Type-Options: nosniff");
        
        // Enable XSS protection in browsers
        header("X-XSS-Protection: 1; mode=block");
        
        // Control referrer information
        header("Referrer-Policy: strict-origin-when-cross-origin");
        
        // Prevent browser from caching sensitive data
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
    }

    /**
     * SetCORSHeaders
     *
     * Sets CORS headers based on whitelist configuration
     * 
     * @param array $AllowedOrigins Array of allowed origins
     * @return void
     */
    public static function SetCORSHeaders($AllowedOrigins = [])
    {
        // Get the origin of the request
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        
        // If no whitelist is provided, use wildcard (not recommended for production)
        if (empty($AllowedOrigins)) {
            header('Access-Control-Allow-Origin: *');
        } 
        // Check if origin is in whitelist
        else if (in_array($origin, $AllowedOrigins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Credentials: true');
        }
        // If origin not allowed, don't set CORS headers (browser will block)
        
        // Set allowed methods
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, HEAD, OPTIONS');
        
        // Set allowed headers
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            // Set cache for preflight requests
            header('Access-Control-Max-Age: 86400'); // 24 hours
            http_response_code(200);
            exit();
        }
    }
}
