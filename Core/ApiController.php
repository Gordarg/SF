<?php

// TODO

/**
 * Abstract Controller class script
 * API Controllers must extend this class
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

// TODO: Every controller must have in-app output (Integration) and parsed output (Web API)

class ApiController
{

	/**
	 * 
	 * FormatData
	 * 
	 * Return data in API format
	 * 
	 */
	function FormatData($Data){
		if (_APIRESULTTYPE=='application/json')
		{
			header("Content-Type: " . _APIRESULTTYPE);
			$json = new Services_JSON();
			return $json->encode($Data);
		}
		else return $Data;
	}


	/**
	 * 
	 * SendResponse
	 * 
	 * Print out response with headers
	 * 
	 */
	public function SendResponse($StatusCode, $Data) {
		$HttpStatus = 'HTTP/1.1 200 Ok';
		switch ($StatusCode)
		{
			case 401:
				$HttpStatus = 'HTTP/1.1 401 Unauthorized';
				break;
			case 403:
				$HttpStatus = 'HTTP/1.0 403 Forbidden';
				break;
			case 404:
				$HttpStatus = 'HTTP/1.0 404 Not Found';
				break;

			default:
				$HttpStatus = 'HTTP/1.1 200 Ok';
		}
		header($HttpStatus);
		echo $this->FormatData($Data);
		exit;
	}

	/**
	 * 
	 * ValidateAutomatic
	 * 
	 * Check Access Level and Validate Login
	 * 
	 */
	function ValidateAutomatic($Role)
	{

	}
}
?>