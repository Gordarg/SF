<?php

include_once '../core/AController.php';
include_once BASEPATH . 'model/Person.php';
include_once BASEPATH . 'core/Authentication.php';

class authController extends AController{

	// TODO: Validate login tokens here
	function GET(){
		parent::GET();
		$result = Authentication::ValidateToken(
			parent::getRequest("Personlogin"),
			parent::getRequest("Token")
		);
		if (!$result)
			parent::setStatus(403);
		parent::setData($result);
		parent::returnData();
	}

	// Login with Username and password
	function POST(){
		parent::POST();
		$result = Authentication::Login(
			parent::getRequest("Username")
			, parent::getRequest("Password")
		);
		if (!$result)
			parent::setStatus(401);
		parent::setData($result);
		parent::returnData();
	}
    
}

$auth = new authController();