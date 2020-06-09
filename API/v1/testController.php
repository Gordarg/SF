<?php

class testController extends ApiController{
	function GET(){
        $this->CheckLogin(); // Check login

		parent::SendResponse(200, 'Well done');
	}
}
