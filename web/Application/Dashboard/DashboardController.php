<?php

namespace Application\Dashboard;

use SportArea\Core\Access;

class DashboardController extends Access
{

    protected $module = 'dashboard';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Dashboard, first page after a user is logged in
     *
     * @author  Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function index()
    {
        $template = array(
            'module'     => $this->module,
            'title'      => 'Dashboard',
            'activeMenu' => 'dashboard'
        );

        $this->render->setData('template', $template);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Dashboard/views/index.html.php'));
        $this->render->renderPage('private.html.php');

        return true;
    }

}
