<?php

class StatisticsController extends Controller {

    /**
     * CommentsGET
     *
     * Statistics of comments and their management
     * 
     * @return void
     */
    function CommentsGET() {

        $this->CheckAuth($_COOKIE); // Check login

        // Initialize the view data to be passed
        $Data = [
            'Title' => 'نظر دهی'
        ];

        // Call the model
        $Model = $this->CallModel("Comment");
        
        // Get grouped count
        $Rows = $Model->GroupedCommentCount();
        $Data['GroupedCommentCountRows'] = $Rows;

        // Render the view
        $this->Render('Comments', $Data);


    }


    /**
     * VisitsGET
     *
     * Statistics of posts view
     * 
     * @return void
     */
    function VisitsGET() {

        $this->CheckAuth($_COOKIE); // Check login

        // Initialize the view data to be passed
        $Data = [
            'Title' => 'بازدید'
        ];

        // Call the model
        $Model = $this->CallModel("Visit");
        
        // Get grouped count
        $Rows = $Model->GroupedVisitCount();
        $Data['GroupedVisitCountRows'] = $Rows;

        // Get grouped visit count by agent
        $Rows = $Model->GroupedVisitCountByAgent();
        $Data['GroupedVisitCountByAgent'] = $Rows;

        // Get grouped visit count by agent
        $Rows = $Model->PostsVisitCountByAddress();
        $Data['PostsVisitCountByAddress'] = $Rows;

        // Render the view
        $this->Render('Visits', $Data);

    }


}