<?php

if (!function_exists('boolval')) {
    function boolval($val)
    {
        return (bool) $val;
    }
}

/**
 * PSR-0 autoloader
 */
function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    $vendorDir = 'vendor';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = ( (!empty($vendorDir) ? $vendorDir."\\" : null) . substr($className, 0, $lastNsPos) );
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    if(preg_match('/Application/i', $fileName)) {
        $fileName = str_replace('vendor\\', '', $fileName);// windows
        $fileName = str_replace('vendor/', '', $fileName);// linux
    }

    if (file_exists($fileName)) {
        require $fileName;
    } else {
        \SportArea\Core\Log::error("File doesn't exist: {$fileName}", __FILE__, __LINE__);
    }
}

spl_autoload_register("autoload");

// Errors/Exceptions handler
set_error_handler(array('\\SportArea\\Core\\Exceptions', 'errorHandler'));
register_shutdown_function(array('\\SportArea\\Core\\Exceptions', 'shutDownFunction'));