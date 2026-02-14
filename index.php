<?php

// Check if configuration file exists
if (!file_exists('Core/Config.php')) {
    // Show user-friendly error message
    die('Configuration file not found. Please copy Core/Config.Sample.php to Core/Config.php and configure your settings.');
}

// Read configuration
include('Core/Config.php');

// HTTPS enforcement for production
// Only enforce if not in debug mode and not already using HTTPS
if (!_Debug && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off')) {
    // Check if this is not a CLI request
    if (php_sapi_name() !== 'cli') {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}

// Load security headers
include('Core/SecurityHeaders.php');

// Set security headers
SecurityHeaders::SetSecurityHeaders();

// Set CORS headers with whitelist support
$corsOrigins = defined('_CORSOrigins') ? _CORSOrigins : [];
SecurityHeaders::SetCORSHeaders($corsOrigins);

// Debug mode
if (_Debug)
{
    // Report all PHP errors
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}
else {
    // Turn off all error reporting
    error_reporting(0);
    
    // Set custom error handler to log errors
    // Note: This only catches recoverable errors (E_USER_ERROR, E_WARNING, etc.)
    // Fatal errors like E_ERROR, E_CORE_ERROR cannot be caught by set_error_handler
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        // Only log serious errors in production
        if ($errno === E_USER_ERROR || $errno === E_WARNING || $errno === E_USER_WARNING) {
            if (class_exists('Logger')) {
                Logger::Error("Error [$errno]: $errstr in $errfile on line $errline");
            }
        }
        // Don't execute PHP internal error handler
        return true;
    });
}

// Exception handler
include('Core/Exceptions.php');

// Cryptography
include('Libs/Cryptography.php');

// Cryptography
include('Libs/APR1.php');

// Random
include('Libs/Random.php');

// Strings
include('Libs/Strings.php');

// Input validator
include('Libs/Validator.php');

// Logger
include('Libs/Logger.php');

// Models core
include('Core/Model.php');

// Rate limiting
include('Core/RateLimit.php');

// Middleware
include('Core/Middleware.php');

// Jalali Date
include('Libs/jdf.php');

// Routing
include('Core/Route.php');

// Security
include('Core/Auth.php');

// Check if it's an MVC API request
if (count((new Route)::GetPathInfo()) > 0 &&
    (new Route)::GetPathInfo()[0] == 'api')
{
    // New JSON library to handle large arrays
    include('Libs/JSON.php');

    // Controllers core
    include('Core/ApiController.php');

    // Router
    include('Core/ApiApp.php');

    // Initialize
    new ApiApp;
}
// If was a MVC request
else
{
    // Markdown
    include('Libs/Parsedown.php');

    // Controllers core
    include('Core/Controller.php');

    // Router
    include('Core/App.php');

    // Initialize
    new App;
}