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

        $template = array(
            'title'      => 'Sport is everywhere',
        );

        $this->render->addCss(BASE_URL . '/Application/Index/assets/css/index.css');
        $this->render->addJsUrl(BASE_URL . '/Application/Index/assets/js/jquery.parallaxmouse.js');
        $this->render->setData('template', $template);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Index/views/index.html.php'));
        $this->render->renderPage('general.html.php');

        return true;
    }

}
