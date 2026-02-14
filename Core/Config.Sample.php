<?php

/**
 * 
 * App configuration
 * 
 */

 // Application name
define('_AppName', 'SF2');

// Default URL (For redirects and etc.)
// IMPORTANT: Use HTTPS in production
define('_Root', getenv('SF_ROOT_URL') ?: 'https://localhost/SF/');

// Debug mode - MUST be false in production
define('_Debug', getenv('SF_DEBUG') === 'true' ? true : false);

// To disable statistics, turn off the flag
define('_Statistics', false);

// The directory used by file manager to upload user files
define('_UploadDirectory', 'Uploads/');

// MySQL Server details
// Use environment variables in production for security
define('_DatabaseServer', getenv('DB_HOST') ?: 'localhost');
define('_DatabaseUsername', getenv('DB_USER') ?: 'root');
define('_DatabasePassword', getenv('DB_PASSWORD') ?: '');
define('_DatabaseName', getenv('DB_NAME') ?: 'SF2');

// CORS allowed origins (empty array = wildcard, not recommended for production)
// Example: define('_CORSOrigins', ['https://example.com', 'https://app.example.com']);
define('_CORSOrigins', []);

// API Result Type
define('_APIRESULTTYPE', 'application/json');

// Mail Server
define('_MailServer', '');
define('_MailUser', '');
define('_MailPassword', '');