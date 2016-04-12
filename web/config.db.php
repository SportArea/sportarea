<?php
/* ***************** */
/* Database settings */
/* ***************** */
$dbDeployment = "local";

switch ($dbDeployment) {
    case "production":
        define("DB_HOST","188.241.222.184");
        define("DB_USERNAME","sportareadb");
        define("DB_PASSWORD","");
        define("DB_NAME","sportareadb");
        define('DB_DRIVER', 'mysql');
        break;

    case "stage":
        define("DB_HOST","localhost");
        define("DB_USERNAME","sportare");
        define("DB_PASSWORD","n7y9Y28tnB");
        define("DB_NAME","sportare_stage");
        define('DB_DRIVER', 'mysql');
        break;

    case "local":
        define('DB_HOST', '127.0.0.1');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'sportareadb');
        define('DB_DRIVER', 'mysql');
        break;

    case "dev01":
        define("DB_HOST","localhost");
        define("DB_USERNAME","sportare");
        define("DB_PASSWORD","n7y9Y28tnB");
        define("DB_NAME","sportare_dev01");
        define('DB_DRIVER', 'mysql');
        break;

    case "dev02":
        define("DB_HOST","localhost");
        define("DB_USERNAME","sportare");
        define("DB_PASSWORD","n7y9Y28tnB");
        define("DB_NAME","sportare_dev02");
        define('DB_DRIVER', 'mysql');
        break;

    default:
        die('Invalid deployment specified.');
        break;
}
?>
