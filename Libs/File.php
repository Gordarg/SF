<?php
class File{
    public static function GetMime($filename){
        
        if (function_exists('mime_content_type') && $mode==0) {
            $mimetype = mime_content_type($filename);
            return $mimetype;
            
        } elseif (function_exists('finfo_open') && $mode==0) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        } elseif (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        } else {
            return 'application/octet-stream';
        } 
    }
    
}