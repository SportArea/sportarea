<?php

namespace Application\Index;


use SportArea\Core\Response;
use SportArea\Core\Uim;
use SportArea\Core\Utils;
use SportArea\Core\Email;
use SportArea\Core\Validate;

class IndexController extends \SportArea\Core\Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render->renderPage('index.html.php');

        return true;
    }

}
