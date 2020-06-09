<?php

class postsController extends ApiController {
    function GET() {
        // (int) trim($_GET['skip'])


        $Model = $this->CallModel("Post");
        $Rows = $Model->GetHomePagePosts();

        for ($i = 0 ; $i < count($Rows) ; $i++)
        {
            $Rows[$i]['Title'] = utf8_decode($Rows[$i]['Title']);
            $Rows[$i]['Body'] = utf8_decode($Rows[$i]['Body']);
        }

		parent::SendResponse(200, $Rows);
    }
}