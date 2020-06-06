<?php

class testController extends ApiController{
	function GET(){
		
		parent::SendResponse(200,"Hello world");
	}
}
