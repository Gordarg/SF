<?php

/**
 * App holder class
 */
class App {
    
    private $Controller = 'HomeController';
    private $DefaultViewDirectoryOfController = 'Home';
    private $View = 'Index';
    private $Params = [];

    /**
     * GetPathInfo
     *
     * Returns URL requested by user
     * 
     * @return array
     */
    function  GetPathInfo(){
        // If does not exist index.php/something
        if (!isset($_SERVER['PATH_INFO']))
            return [];

        // else
        $PathInfo = trim(
            $_SERVER['PATH_INFO']
            , '/');

        return explode('/', $PathInfo);
    }


    /**
     * ThowError
     *
     * Throw low level errors which are log-able from web server
     * 
     * @return array
     */
    public function ThowError($HttpStatusCode, $Message = '') {
        switch ($HttpStatusCode)
        {
            case 403:
                header('HTTP/1.0 403 Forbidden');
                include('static/errors/HTTP403.html');
                exit;
            case 404:
                header('HTTP/1.0 404 Not Found');
                include('static/errors/HTTP404.html');
                exit;
            default:
                throw new Exception($Message);
                die();
        }
    }

    /**
     * __construct
     *
     * Class Constructor which is called on any request
     * 
     * @return void
     */
    function __construct(){
        // Get URL
        $URL = $this->GetPathInfo();

        // Routing
        // TODO: Use a routing mechanism which allows configuration
        // Set Controller
        
        if (isset($URL[0]))
        {
            $this->DefaultViewDirectoryOfController = $URL[0];
            $this->Controller = $URL[0].'Controller';
            unset($URL[0]);
        }
        // Set View
        if (isset($URL[1]))
        {
            $this->View = $URL[1];
            unset($URL[1]);
        }
        
        // Get other parameters
        $this->Params = array_values($URL);
        // Call the method form class
        $ControllerFilePath = 'Controller/' . $this->Controller.'.php';
        // If controller file does not exist
        if (!file_exists($ControllerFilePath))
        $this->ThowError(404);
        // Include the controller file
        include($ControllerFilePath);
        // Create an instance of controller class
        $ClassObject = new $this->Controller();
        // Set the view folder
        $ClassObject->SetViewDirectory($this->DefaultViewDirectoryOfController);
        // Get the method
        $HttpMethod = $_SERVER['REQUEST_METHOD'];
        // Get the request body
        switch ($HttpMethod)
        {
            // HTTP METHOD DELETE or HTTP METHOD PUT
            case "DELETE":
            case "PUT":
                $raw_data = file_get_contents('php://input');
                $_PUT = array();
                $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));
                if ($boundary == null) // x-www-form-urlencoded
                {
                    $split_parameters = explode('&', $raw_data);

                    for($i = 0; $i < count($split_parameters); $i++) {
                        $final_split = explode('=', $split_parameters[$i]);
                        $_PUT[$final_split[0]] = $final_split[1];
                    }
                }
                else // form-data
                {
                    $parts = array_slice(explode($boundary, $raw_data), 1);
                    foreach ($parts as $part) {
                        if ($part == "--\r\n") break; 
                        $part = ltrim($part, "\r\n");
                        list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);
                        $raw_headers = explode("\r\n", $raw_headers);
                        $headers = array();
                        foreach ($raw_headers as $header) {
                            list($name, $value) = explode(':', $header);
                            $headers[strtolower($name)] = ltrim($value, ' '); 
                        }
                        if (isset($headers['content-disposition'])) {
                            $filename = null;
                            preg_match(
                                '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/', 
                                $headers['content-disposition'], 
                                $matches
                            );
                            list(, $type, $name) = $matches;
                            isset($matches[4]) and $filename = $matches[4]; 
                            switch ($name) {
                                case 'userfile':
                                    file_put_contents($filename, $body);
                                    break;
                                default: 
                                    $_PUT[$name] = substr($body, 0, strlen($body) - 2);
                                    break;
                            } 
                        }

                    }
                }
                $RequestBody = $_PUT;
                break;

            // HTTP METHOD POST
            case "POST":
                $RequestBody = $_GET;
                break;
            // HTTP METHOD GET
            default:
                $RequestBody = $_GET;

        }
        // Find the function
        $ControllerMethod = $this->View . $HttpMethod;
        // Call the method if exists
        if (!method_exists($ClassObject, $ControllerMethod))
            $this->ThowError(404);
        try {
            // Call the view
            call_user_func_array([$ClassObject, $ControllerMethod], $this->Params);
        } catch (AuthException $exp ){ // On auth error
            $this->ThowError(403);
        } catch (NotFoundException $exp ){ // on not found error
            $this->ThowError(404);
        }
    }

}