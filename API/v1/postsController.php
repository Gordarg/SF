<?php

class postsController extends ApiController {
    function GET() {
        // (int) trim($_GET['skip'])

        $this->CheckLogin(); // Check login

        $Model = $this->CallModel("Post");
        $Rows = $Model->GetAllPosts();

        for ($i = 0 ; $i < count($Rows) ; $i++)
        {
            $Rows[$i]['Title'] = utf8_decode($Rows[$i]['Title']);
        }

		parent::SendResponse(200, $Rows);
    }
}