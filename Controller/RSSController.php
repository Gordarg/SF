<?php
class RSSController extends Controller{
    
    /**
     * RSSGET
     *
     * RSS Feed
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


        header("Content-type: text/xml");
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<rss version=\"2.0\">

<channel>
<title>$Title</title>
<link>$Link</link>
<description>$Description</description>
$items_str
</channel>

</rss>";
    }
}