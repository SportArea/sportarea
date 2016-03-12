<?php

/**
 * Environment
 * Can be: dev, prod
 */
define('ENVIRONMENT', 'dev');

define('ROOT', getcwd());

/**
 * Base URL
 */
$port = ($_SERVER['SERVER_PORT'] == '80') ? '' : (':'. $_SERVER['SERVER_PORT']);

// If no HTTPS
if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == '' || $_SERVER['HTTPS'] == 'off') {
    define('BASE_URL', 'http://'. $_SERVER['SERVER_NAME'] . $port);
    define('_BASE_URL_', 'http://'. $_SERVER['SERVER_NAME'] . $port);

// If HTTPS
} else {
    define('BASE_URL', 'https://'. $_SERVER['SERVER_NAME'] . $port);
    define('_BASE_URL_', 'https://'. $_SERVER['SERVER_NAME'] . $port);
}

define('_APP_DIR_', 'Application');

/**
 * Time To Live for the authentication cookie
 */
define('AUTH_COOKIE_TTL', 30 * 86400);

/**
 * Do not change it is not necessary
 */
define('SALT', '?-234#g$%9AF?{;Qf#>Mg44ya}X@rPAQ|%{-B1)?V=s4A,TrE(5{Q``=oK?>-G|d');

/**
 * Application version. Do not change it manually. This is ANT's job.
 */
define('VERSION', '0.0.1');

require_once ROOT .'/config.db.php';
require_once ROOT. '/config.routes.php';
require_once ROOT. '/config.settings.php';

if(file_exists(ROOT. '/cache/settings.php')) {
    require_once ROOT. '/cache/settings.php';
}