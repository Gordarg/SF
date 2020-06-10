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
            'MasterId' => $this->RequestBody['MasterId'],
            'Title' => $this->RequestBody['Title'],
            'BinContent' => $this->RequestBody['BinContent'],
            'Body' => $this->RequestBody['Body'],
            'UserId' => $this->RequestBody['UserId'],
            'Status' => $this->RequestBody['Status'],
            'Language' => $this->RequestBody['Language'],
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