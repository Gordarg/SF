<?php


// Read configuration
include('Core/Config.php');

if (_Debug)
    // Report all PHP errors
    error_reporting(-1);
else
    // Turn off all error reporting
    error_reporting(0);

// Exception handler
include('Core/Exceptions.php');

// Cryptography
include('Libs/Cryptography.php');

// Models core
include('Core/Model.php');

// Jalali Date
include('Libs/jdf.php');

// Controllers core
include('Core/Controller.php');

// Router
include('Core/App.php');

new App;