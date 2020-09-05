<?php
class Route {
    /**
     * GetPathInfo
     *
     * Returns URL requested by Person
     * 
     * @return array
     */
    static function GetPathInfo(){

        
        $ActualLink = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        // $ParsedUrl = parse_url($ActualLink);

        // Use path info if exists
        // index.php/value1/value2
        if (isset($_SERVER['PATH_INFO']))
            $PathInfo = trim(
                $_SERVER['PATH_INFO']
                , '/');
        // Use query string if exists
        // index.php?/value1/value2
        else if (isset($_SERVER['QUERY_STRING']))
            $PathInfo = trim(
                $_SERVER['QUERY_STRING']
                , '/');
        // return null if no one exist
        else
            return [];
        
        // convert to array and return
        $Output = explode('/', $PathInfo);

        // Add other query strings to  the last parameter
        if ($PathInfo == '')
            return $Output;

        $LeftOver = substr($ActualLink,
        strpos($ActualLink, $PathInfo) + strlen($PathInfo));
        if ($LeftOver != '' && str_replace($LeftOver, '', '/') != '')
            array_push($Output, urldecode($LeftOver));

        // return
        return $Output;

        // TODO: Allow dynamic routing

        // === Returns:

        // If api
        // Index 0: 'api'
        // Index 1: Version
        // Index 2: Controller
        
        // Else if not api
        // Index 0: Controller
        // Index 1: Action
    }
}