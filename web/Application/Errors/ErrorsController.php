<?php

namespace Application\Errors;

// APLICATION
use Application\Errors\ErrorsModel;


// CORE
use SportArea\Core\Access;
use SportArea\Core\Uim;
use SportArea\Core\Validate;

/**
 */
class ErrorsController extends Access
{
    protected $module = 'errors';

    /**
     * @param   integer $currentPage
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function index($currentPage = null)
    {
        $template = array(
            'module'        => $this->module,
            'title'         => 'Erori sistem',
            'activeMenu'    => 'errors',
            'activeTab'     => 'errors',
            'method'        => __FUNCTION__
        );

		// Set curent page to 1
		if( (isset($_SESSION[$this->module]['filter']) AND Validate::isArray($_SESSION[$this->module]['filter'], null, 1) AND $currentPage == null)
				OR ($currentPage == null AND !isset($_SESSION[$this->module]['currentPage'])) ) {
			$currentPage = $_SESSION[$this->module]['currentPage'] = 1;

		// Get curent page from session
		} else if($currentPage == null && isset($_SESSION[$this->module]['currentPage']) && Validate::integer($_SESSION[$this->module]['currentPage'], null, 1)) {
			$currentPage = $_SESSION[$this->module]['currentPage'];

		} else {
			$_SESSION[$this->module]['currentPage'] = $currentPage;
		}

		if(!isset($_SESSION[$this->module]['orderBy']) || !isset($_SESSION[$this->module]['orderDirection'])) {
			$_SESSION[$this->module]['orderBy']			= 'errors.last_seen';
			$_SESSION[$this->module]['orderDirection']	= 'ASC';
		}

        $ErrorsModel    = new ErrorsModel();
        $resultsPerPage	= (!isset($_SESSION[$this->module]['resultsPerPage'])) ? SETTINGS_RESULTS_PER_PAGE : $_SESSION[$this->module]['resultsPerPage'];
        $resultsCount   = $ErrorsModel->listByFilters(false, true);
        $totalPages		= ceil($resultsCount/$resultsPerPage);
        $errors         = $ErrorsModel->listByFilters((($currentPage * $resultsPerPage) - $resultsPerPage) .','. $resultsPerPage);

        $template['pagination'] = array(
            'resultsPerPage'    =>  $resultsPerPage,
            'totalEntries'      =>  $resultsCount,
            'totalPages'        =>  $totalPages,
            'currentPage'       =>  $currentPage
        );

        $this->render->setData('template', $template);
        $this->render->setData('errors', $errors);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Errors/views/index.html.php'));
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
            $this->filters($this->module);
        } else {
            if($this->request) {
                $this->filters(
                    $this->module,
                    array('type')
                );
            }
        }

        $this->response->redirect(BASE_URL .'/errors/index');
    }

    public function delete($errorID = null)
    {
        $errorID = abs(intval($errorID));

        $ErrorsModel    = new ErrorsModel();

        $error = $ErrorsModel->getByID($errorID);

        if(Validate::isArray($error, NULL, 1)) {
            if($ErrorsModel->deleteByID($errorID)) {
                Uim::addMessage('Eroarea a fost stersa.');
            } else {
                Uim::addError('Eroarea nu a putut fi stearsa.');
            }

        } else {
            Uim::addError('Eroare inexistentă.');
            // TODO: log this
        }

        $this->response->redirect(BASE_URL .'/errors/index');
    }
}