<?php
/* ***************** */
/* Database settings */
/* ***************** */
$dbDeployment = "local";

switch ($dbDeployment) {
    case "production":
        define("DB_HOST","188.241.222.184");
        define("DB_USERNAME","sportare_devel");
        define("DB_PASSWORD","");
        define("DB_NAME","sportare_devel");
        define('DB_DRIVER', 'mysql');
        break;

    case "dev":
        define("DB_HOST","188.241.222.184");
        define("DB_USERNAME","sportare_devel");
        define("DB_PASSWORD","");
        define("DB_NAME","sportare_devel");
        define('DB_DRIVER', 'mysql');
        break;

    case "local":
        define('DB_HOST', '127.0.0.1');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'sportarea_devel');
        define('DB_DRIVER', 'mysql');
        break;

    default:
        die('Invalid deployment specified.');
        break;
}

?>
