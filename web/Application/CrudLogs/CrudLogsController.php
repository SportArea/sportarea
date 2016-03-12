<?php

namespace Application\CrudLogs;

// APLICATION
use Application\Errors\ErrorsModel;

// CORE
use SportArea\Core\Access;
use SportArea\Core\Uim;
use SportArea\Core\Validate;


class CrudLogsController extends Access
{

    private $table = 'crud_logs';

    /**
     * @param   integer $currentPage
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function index($currentPage = null)
    {
        $template = array(
            'module'         => $this->table,
            'title'         => 'Loguri CRUD',
            'activeMenu'    => 'crud_logs',
            'activeTab'     => 'crud_logs',
            'method'        => __FUNCTION__
        );

		// Set curent page to 1
		if( (isset($_SESSION[$this->table]['filter']) AND Validate::isArray($_SESSION[$this->table]['filter'], null, 1) AND $currentPage == null)
				OR ($currentPage == null AND !isset($_SESSION[$this->table]['currentPage'])) ) {
			$currentPage = $_SESSION[$this->table]['currentPage'] = 1;

		// Get curent page from session
		} else if($currentPage == null && isset($_SESSION[$this->table]['currentPage']) && Validate::integer($_SESSION[$this->table]['currentPage'], null, 1)) {
			$currentPage = $_SESSION[$this->table]['currentPage'];

		} else {
			$_SESSION[$this->table]['currentPage'] = $currentPage;
		}

		if(!isset($_SESSION[$this->table]['orderBy']) || !isset($_SESSION[$this->table]['orderDirection'])) {
			$_SESSION[$this->table]['orderBy']			= 'cases.id';
			$_SESSION[$this->table]['orderDirection']	= 'ASC';
		}

        $CrudLogs       = new CrudLogsModel();
        $resultsPerPage	= (!isset($_SESSION[$this->table]['resultsPerPage'])) ? SETTINGS_RESULTS_PER_PAGE : $_SESSION[$this->table]['resultsPerPage'];
        $resultsCount   = $CrudLogs->listByFilters(false, true);
        $totalPages		= ceil($resultsCount/$resultsPerPage);
        $errors         = $CrudLogs->listByFilters((($currentPage * $resultsPerPage) - $resultsPerPage) .','. $resultsPerPage);

        $template['pagination'] = array(
            'resultsPerPage'    =>  $resultsPerPage,
            'totalEntries'      =>  $resultsCount,
            'totalPages'        =>  $totalPages,
            'currentPage'       =>  $currentPage
        );

        $this->render->setData('template', $template);
        $this->render->setData('errors', $errors);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/CrudLogs/views/index.html.php'));
        $this->render->renderPage('private.html.php'); return true;
    }

    /**
     * Apply or reset users filters
     *
     * @param   string  $reset
     */
    public function filter($reset = false)
    {
        // Reset all users filters
        if($reset !== false) {
            $this->filters($this->table);
        } else {
            if($this->request) {
                $this->filters(
                    $this->table,
                    array('type')
                );
            }
        }

        $this->response->redirect(BASE_URL .'/crud_logs/index');
    }
}