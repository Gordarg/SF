<?php

/**
 * 
 * App configuration
 * 
 */

 // Application name
define('_AppName', 'SF2');

// Default URL (For redirects and etc.)
define('_Root', 'http://localhost/SnowFramework2/');

// TODO: WARNING: Disable debug on production server
define('_Debug', true);

// To disable statistics, turn off the flag
define('_Statistics', false);

// The directory used by file manager to upload user files
define('_UploadDirectory', 'Uploads/');

// MySQL Server details
define('_DatabaseServer', 'localhost');
define('_DatabaseUsername', 'root');
define('_DatabasePassword', '');
define('_DatabaseName', 'SF2');

// API Result Type
define('_APIRESULTTYPE', 'application/json');

// Mail Server
define('_MailServer', '');
define('_MailUser', '');
define('_MailPassword', '');