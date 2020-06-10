<?php

class postsController extends ApiController {
    function GET($IdOrFrom = -1, $To = -1) {
        $this->CheckLogin(); // Check login

        // Select single post
        if ($To == -1 && $IdOrFrom != -1)
        {
            $Model = $this->CallModel("Post");
            $Rows = $Model->GetPostByMasterId(
                ['MasterId' => $IdOrFrom]
            );
            $Rows[1]['Title'] = utf8_decode($Rows[1]['Title']);
            $Rows[1]['Body'] = utf8_decode($Rows[1]['Body']);
        }
        // Select multiple posts
        else
        {
            $Model = $this->CallModel("Post");
            $Rows = $Model->GetAllPosts();

            $From = (int) trim($IdOrFrom);
            $To = (int) trim($To);
            for ($i = 0 ; $i < count($Rows) ; $i++)
            {
                $Rows[$i]['Title'] = utf8_decode($Rows[$i]['Title']);
            }

            parent::SendResponse(200, $Rows);
        }
    }
    function POST() {

        $this->CheckLogin(); // Check login

        $Values = [
            'MasterId' => (new Random())::GenerateGUID(),
            'Title' => $this->RequestBody['title'],
            'BinContent' => base64_encode(file_get_contents($this->RequestBody[0]['content']['tmp_name'][0])),
            'Body' => $this->RequestBody['body'],
            'UserId' => 1,// $this->RequestBody['UserId'], // TODO: Attention
            'Status' => $this->RequestBody['status'],
            'Language' => 'fa-IR' // $this->RequestBody['language'],
        ];

        $Model = $this->CallModel("Post");
        $Model->InsertPost($Values);

        parent::SendResponse(200, $this->RequestBody);

    }
    function PUT() {

    }
    function DELETE() {

    }
}