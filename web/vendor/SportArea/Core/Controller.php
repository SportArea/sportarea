<?php

namespace SportArea\Core;

class Controller extends Core
{
    public function __construct()
    {
        parent::__construct();
    }

    public function filters($table, $filterParams = array())
    {
        if(!Validate::isArray($filterParams, null, 1)) {
            unset($_SESSION[$table]['filter']);

        } else {
            foreach ($filterParams as $filterParam) {
                if(!empty($this->request[$filterParam])) {
                    $_SESSION[$table]['filter'][$filterParam] = trim($this->request[$filterParam]);
                } else {
                    unset($_SESSION[$table]['filter'][$filterParam]);
                }
            }
        }
    }

    public function jsonResponse($response)
    {
        echo json_encode($response);
        exit(0);
    }
}