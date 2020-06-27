<?php
// Read configuration
include('Core/Config.php');

// CORS
header('Access-Control-Allow-Origin: *');

// Allowed methods
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, HEAD, VIEW');

// Debuf mode
if (_Debug)
{
    // Report all PHP errors
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}
else
    // Turn off all error reporting
    error_reporting(0);

// Exception handler
include('Core/Exceptions.php');

// Cryptography
include('Libs/Cryptography.php');

// Random
include('Libs/Random.php');

// Strings
include('Libs/Strings.php');

// Models core
include('Core/Model.php');

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