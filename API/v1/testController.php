<?php

class testController extends ApiController{
	function GET(){
        $this->CheckLogin($_COOKIE); // Check login

		parent::SendResponse(200, 'Well done');
	}
}
