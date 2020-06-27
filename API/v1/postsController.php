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
            'PersonId' => 1,// $this->RequestBody['PersonId'], // TODO: Attention
            'Status' => $this->RequestBody['status'],
            'Language' => 'fa-IR' // $this->RequestBody['language'],
        ];

        $Model = $this->CallModel("Post");
        $Model->InsertPost($Values);

        parent::SendResponse(200, $this->RequestBody);

    }
    function PUT() {

        $bincontent = null;
        if (isset($this->RequestBody['content[]']))
            // $bincontent = base64_encode(file_get_contents($this->RequestBody['content']['tmp_name'][0]));
            $bincontent = base64_encode($this->RequestBody['content[]']);

        $Values = [
            'MasterId' =>$this->RequestBody['masterid'],
            'Title' => $this->RequestBody['title'],
            'BinContent' => $bincontent,
            'Body' => $this->RequestBody['body'],
            'PersonId' => 1,// $this->RequestBody['PersonId'], // TODO: Attention
            'Status' => $this->RequestBody['status'],
            'IsContentDeleted' => isset($this->RequestBody['deletecontent']),
            'Language' => 'fa-IR' // $this->RequestBody['language'],
        ];

        $Model = $this->CallModel("Post");
        $Model->UpdatePost($Values);

        parent::SendResponse(200, "Post '" . $this->RequestBody['masterid'] . "' updated successfuly.");
    }
    function DELETE() {
        $Values = [
            'MasterId' =>$this->RequestBody['masterid'],
            'Title' => $this->RequestBody['title'],
            'Body' => $this->RequestBody['body'],
            'PersonId' => 1,// $this->RequestBody['PersonId'], // TODO: Attention
            'Language' => 'fa-IR' // $this->RequestBody['language'],
        ];

        $Model = $this->CallModel("Post");
        $Model->DeletePost($Values);

        parent::SendResponse(200, "Post '" . $this->RequestBody['masterid'] . "' deleted successfuly.");
    }
}