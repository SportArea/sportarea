<?php
ini_set('display_errors', '1');
ini_set('session.gc_maxlifetime', 8 * 3600);

$memory = memory_get_usage(); $start = microtime(true);

header('Content-Type: text/html; charset=utf-8');

require_once './config.app.php';
require_once ROOT .'/vendor/autoload.php';

/**
 * Router
 */
new \SportArea\Core\Router();
