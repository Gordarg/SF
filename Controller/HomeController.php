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
    function ViewGET($Id = 0, $Success = '') {

        // If Id wasnt passed to the method
        if (!$Id)
            throw new NotFoundException();            

        // Call the model
        $Entity = $this->CallModel("Post");

        // Get the post by Id passed from URI
        $Model = $Entity->GetPostById([
            'Id' => $Id,
        ]);

        // If post not found in db
        if (!isset($Model[0]))
            throw new NotFoundException();

        // Get the first and only row
        $Model = $Model[0];

        // Prepare the message
        switch ($Success)
        {
            case "Success":
                $Message = "نظر شما با موفقیت ثبت شد و در انتظار تایید است";
                break;
            case "Failure":
                $Message = "خطایی رخ داده است. لطفا بعدا تلاش کنید";
                break;

            default:
                break;
        }

        // Get comments
        // Call the model
        $CommentsEntity = $this->CallModel("Comment");

        // Get the post by Id passed from URI
        $Comments = $CommentsEntity->GetPostComments([
            'Id' => $Id,
        ]);

        
        // Make ready for display
        for ($i = 0 ; $i < count($Comments) ; $i++)
        {
            $Comments[$i]['Body'] = utf8_decode($Comments[$i]['Body']);
            $Comments[$i]['Name'] = utf8_decode($Comments[$i]['Name']);
        }

        // Prepare for render
        $Data = [
            'Title' => utf8_decode($Model['Title']),
            'Model' => [
                'Id' => $Model['Id'],
                'Title' => utf8_decode($Model['Title']),
                'Body' => utf8_decode(htmlspecialchars_decode($Model['Body'])),
                'Abstract' => utf8_decode($Model['Abstract']),
                'FileName' => $Model['FileName'],
                'Year' => $Model['Year'],
                'Month' => $Model['Month'],
                'Day' => $Model['Day'],
            ],
            'CommentsModel' => $Comments,
            'Message' => isset($Message) ? $Message : null
        ];
        
        // Render the page
        $this->Render('View', $Data);
    }


   /**
     * Index
     *
     * CommentPOST
     * 
     * @return void
     */
    function CommentPOST($Id = 0) {

        // If post id wasn't passed
        if (!$Id)
            throw new NotFoundException();

        // Make values ready for insert or update
        $Values = [
            'Name' => utf8_encode($_POST['NameInput']),
            'Body' => utf8_encode(htmlspecialchars($_POST['BodyInput'])),
            'EMail' => $_POST['EMailInput'],
            'IsPublic' => !isset($_POST['IsPublicInput']) || !$_POST['IsPublicInput'] ? /*decbin(0)*/ 0b0 : 0b1,
            'PostId' => $Id
        ];

        // Ask database to be ready
        $Model = $this->CallModel("Comment");

        // Insert into database
        $Response = $Model->InsertNewComment($Values);

        if ($Response)
            // Redidrect response
            $this->RedirectResponse(_Root . "Home/View/" . $Id . '/Success');
        else
            $this->RedirectResponse(_Root . "Home/View/" . $Id . '/Failure');
    }
}