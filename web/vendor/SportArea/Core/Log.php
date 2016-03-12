<?php

namespace SportArea\Core;

class Log
{

    private static function content()
    {
        return date('H:i:s');
    }

    public static function event($data, $file, $line)
    {
        self::flush(__FUNCTION__, $data, $file, $line);
    }

    public static function warning($data, $file, $line)
    {
        self::flush(__FUNCTION__, $data, $file, $line);
    }

    public static function error($data, $file, $line)
    {
        self::flush(__FUNCTION__, $data, $file, $line);
    }

    private static function flush($errorType, $data, $file, $line) {
        file_put_contents(ROOT .'/logs/'. $errorType .'_'.date('Y-m-d').'.log', self::content()."\n\tFile: {$file}\n\tLine: {$line}\n\t". $data."\n", FILE_APPEND);
    }

}