<?php

/**
 * 
 * Controller class for admin panel
 * 
 */
trait FileManager {
    /**
     * 
     * FilesGET
     * 
     * Embded Filemanager
     * 
     * 
     */
    function FilesGET() {
        $this->CheckAuth(); // Check login
        
        define('FM_EMBED', true);
        define('FM_SELF_URL', _Root . 'My/Files/'); // must be set if URL to manager not equal PHP_SELF
        require 'Libs/filemanager/filemanager.php';
    }
    /**
     * 
     * FilesPost
     * 
     * Embded Filemanager
     * 
     * 
     */
    function FilesPOST() {
        $this->CheckAuth(); // Check login

        define('FM_EMBED', true);
        define('FM_SELF_URL', _Root . 'My/Files/'); // must be set if URL to manager not equal PHP_SELF
        require 'Libs/filemanager/filemanager.php';
    }
}