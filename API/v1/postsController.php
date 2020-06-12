<?php

class postsController extends ApiController {
    function GET($IdOrFrom = -1, $To = -1) {
        $this->CheckLogin(); // Check login

        // Select single post by id
        if ((!is_array($IdOrFrom) && $IdOrFrom != -1) && $To == -1)
        {
            $Model = $this->CallModel("Post");
            $Rows = $Model->GetPostById(
                ['Id' => $IdOrFrom]
            );

            if (count($Rows) == 0)
            throw new NotFoundException('Post with passed Id not found.');

            $Rows[0]['Title'] = utf8_decode($Rows[0]['Title']);
            $Rows[0]['Body'] = utf8_decode($Rows[0]['Body']);

            parent::SendResponse(200, $Rows);

        }
        // Select multiple posts with limitations
        else
        {

            // Lazy load limitations
            $From = 0;
            if (!is_array($IdOrFrom) && $IdOrFrom>0)
                $From =  (int) trim($IdOrFrom);
            if ($To == -1)
                $To = 50;
            else $To = (int) trim($To);

            // Call the model
            $Model = $this->CallModel("Post");
            $Rows = $Model->GetAllPosts([
                'From' => $From,
                'To' => $To
            ]);

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
        $Model->UpdatePost($Values);

        parent::SendResponse(200, $this->RequestBody);
    }
    function DELETE() {
        $Model = $this->CallModel("Post");
        $Model->DeletePost($Values);

        parent::SendResponse(200, $this->RequestBody);
    }
}