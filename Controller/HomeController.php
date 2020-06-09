<?php

/**
 * 
 * Controller class for public home pages
 * 
 */
class HomeController extends Controller {

    /**
     * Index
     *
     * Home page
     * 
     * @return void
     */
    function IndexGET() {

        $Model = $this->CallModel("Post");
        $Rows = $Model->GetHomePagePosts();

        for ($i = 0 ; $i < count($Rows) ; $i++)
        {
            $Rows[$i]['Title'] = utf8_decode($Rows[$i]['Title']);
            $Rows[$i]['Body'] = utf8_decode($Rows[$i]['Body']);
        }

        $Data = [
            'Title' => _AppName,
            'Model' => $Rows
        ];

        $this->Render('Index', $Data);
    }

    /**
     * FeedGET
     * 
     * Human friendly view of RSS Home feed
     * 
     */
    function FeedGET(){

        // Call model
        $Model = $this->CallModel("Post");
        $Rows = $Model->GetHomePagePosts();

        // Decode UTF-8
        for ($i = 0 ; $i < count($Rows) ; $i++)
        {
            $Rows[$i]['Title'] = utf8_decode($Rows[$i]['Title']);
            $Rows[$i]['Body'] = utf8_decode($Rows[$i]['Body']);
        }


        // Build RSS
        $Title = _AppName;
        $Link = _Root;
        $Description = ''; // TODO: Description

        $items_str = '';
        for ($i = 0 ; $i < count($Rows) ; $i++)
        {
            $item_title = $Rows[$i]['Title'];
            $item_link = _Root . 'Home/View/' . $Rows[$i]['MasterID'];
            $item_abstract = $Rows[$i]['Body'];


            $items_str .= "<item>
    <title>$item_title</title>
    <link>$item_link</link>
    <description>$item_abstract</description>
</item>
";
        }

        $output_str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<rss version=\"2.0\">

<channel>
<title>$Title</title>
<link>$Link</link>
<description>$Description</description>
$items_str
</channel>

</rss>";

        // Serialize the output to pass
        $Data = [
            'Title' => _AppName,
            'Result' => htmlentities($output_str)
        ];

        // Render the page
        $this->Render('Feed', $Data);
    }


    /**
     * ViewGET
     *
     * View the post page
     * 
     * @return void
     */
    function ViewGET($Language = 0, $MasterID = 0) {
        

        // If Id wasnt passed to the method
        if (!$Language || !$MasterID)
            throw new NotFoundException();       

        // call the model
        $Entity = $this->CallModel('Post');
        $Model = $Entity->GetPost([
            'Language' => $Language,
            'MasterID' => $MasterID
        ]);

        // If post not found in db
        if (!isset($Model[0]))
            throw new NotFoundException();
     
        // Fetch the first and only record
        $Model = $Model[0];


        // Prepare for render
        $Data = [
            'Title' => utf8_decode($Model['Title']),
            'Model' => [
                'MasterID' => $Model['MasterID'],
                'Id' => $Model['Id'],
                'Language' => $Model['Language'],
                'Title' => utf8_decode($Model['Title']),
                'Body' => utf8_decode(htmlspecialchars_decode($Model['Body'])),
                'Year' => $Model['Year'],
                'Month' => $Model['Month'],
                'Day' => $Model['Day'],
                'Username' => $Model['Username'],
            ]
        ];
        
        // Render the page
        $this->Render('View', $Data);
    }
}