<?php

class ApiApp
{
	protected $HttpStatus;
	protected $Controller;
	protected $Version;
	
	function __construct(){

		// Get URL
		$URL = Route::GetPathInfo();

		// Routing
		// Version
		$this->Version = $URL[1];
		// Controller
		$this->Controller = $URL[2].'Controller';

		// Call the method form class
		$ControllerFilePath = 'API/' . $this->Version . '/' . $this->Controller.'.php';
		// Include the controller file
		include($ControllerFilePath);
		// Create an instance of controller class
		$ClassObject = new $this->Controller();
		// Set the method function
		$ControllerMethod = $_SERVER['REQUEST_METHOD'];
		// Set request body
		$RequestBody = [];
		switch ($ControllerMethod)
		{
			case "DELETE":
			case "PUT":
				$raw_data = file_get_contents('php://input');
				$RequestBody = array();
				$boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));
				if ($boundary == null && $raw_data != 'null') // x-www-form-urlencoded
				{
					$split_parameters = explode('&', $raw_data);
					for($i = 0; $i < count($split_parameters); $i++) {
						$final_split = explode('=', $split_parameters[$i]);
						$result[$final_split[0]] = $final_split[1];
					}
				}
				else if ($raw_data != 'null')
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
									$result[$name] = substr($body, 0, strlen($body) - 2);
									break;
							} 
						}
					}
				}
				else
				{
					$url = $_SERVER['REQUEST_URI'];
					$split_parameters = explode('&', $url);
					for($i = 0; $i < count($split_parameters); $i++) {
						$final_split = explode('=', $split_parameters[$i]);
						$result[$final_split[0]] = $final_split[1];
					}
				}
				break;

				case "POST":
					$RequestBody = $_POST;
					break;

				default:
					$RequestBody = $_GET;

		}
		// Call the method if exists
		if (!method_exists($ClassObject, $ControllerMethod))
			$ClassObject->SendResponse(404,'Not Found');
		try {
			// Call the method
			call_user_func_array([$ClassObject, $ControllerMethod], $RequestBody);
		} catch (AuthException $exp ){ // On auth error
			$ClassObject->SendResponse(401,'Login required');
		} catch (NotFoundException $exp ){ // on not found error
			$ClassObject->SendResponse(404,'Not Found');
		}


	}
	
}
?>