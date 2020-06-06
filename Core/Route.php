<?php
class Route {
    /**
     * GetPathInfo
     *
     * Returns URL requested by user
     * 
     * @return array
     */
    static function GetPathInfo(){
        // If does not exist index.php/something
        if (!isset($_SERVER['PATH_INFO']))
            return [];

        // else
        $PathInfo = trim(
            $_SERVER['PATH_INFO']
            , '/');

        return explode('/', $PathInfo);

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