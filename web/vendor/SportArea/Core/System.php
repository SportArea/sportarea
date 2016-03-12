<?php

namespace SportArea\Core;

// Core
use SportArea\Core\Validate;

class System
{
    public function checkExtension($FILE, $mimeTypes, $extensions)
    {
        if(!isset($FILE['tmp_name'])) {
            return false;
        }
        
        list($mimeType, $encryption) = explode(';', finfo_file(finfo_open(FILEINFO_MIME), $FILE['tmp_name']));
        $extension  = pathinfo($FILE['name'], PATHINFO_EXTENSION);

        if( (Validate::isArray($mimeTypes, null, 1) && !in_array($mimeType, $mimeTypes))
                || (Validate::isArray($extensions, null, 1) && !in_array($extension, $extensions)) ) {
            return false;
        }

        return true;
    }
}