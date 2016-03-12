<?php

namespace SportArea\Core;

class Defines
{

    private $constants = array(
        'ROOT'          =>  null,
        'BASE_URL'      =>  null,
        'ENVIRONMENT'   =>  'prod',
        'SQL_VERSION'   =>  null,
        'APP_VERSION'   =>  null
    );

    private $overwrite = array();

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {

        foreach ($this->constants as $constant => $constantValue) {

            /**
             * ROOT - the mai directory of the application
             */
            if($constant == 'ROOT') {
                (isset($this->overwrite['ROOT'])) ? define('ROOT', $this->overwrite['ROOT']) : define('ROOT', getcwd());

            /**
             * BASE_URL
             */
            } else if($constant == 'BASE_URL') {
                $port = ($_SERVER['SERVER_PORT'] == '80') ? '' : (':'. $_SERVER['SERVER_PORT']);

                // If no HTTPS
                if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == '' || $_SERVER['HTTPS'] == 'off') {
                    define('BASE_URL', 'http://'. $_SERVER['SERVER_NAME'] . $port);

                // If HTTPS
                } else {
                    define('BASE_URL', 'https://'. $_SERVER['SERVER_NAME'] . $port);
                }

            /**
             * ENVIRONMENT
             */
            } else if($constant == 'ENVIRONMENT') {
                (isset($this->overwrite['ENVIRONMENT'])) ? define('ENVIRONMENT', $this->overwrite['ENVIRONMENT']) : define('ENVIRONMENT', $constantValue);

            } else {
                (isset($this->overwrite[$constant])) ? define($constant, $this->overwrite[$constant]) : define($constant, $constantValue);
            }

        }
    }

    public function set($constantName, $value) {
        if(array_key_exists($constantName, $this->constants)) {
            $this->overwrite[$constantName] = $value;
        } else {
            Log::warning("Try to define an undefined variable: {$constantName} = {$value}", __FILE__, __LINE__);
        }
    }
}
