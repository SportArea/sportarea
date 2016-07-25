<?php
/**
 * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
 */

namespace Application\SportType;

use SportArea\Core\Response;
use SportArea\Core\Uim;
class SportTypeController extends \SportArea\Core\Controller
{
    protected $module = 'sport_type';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     *
     * @return bool
     * @throws \Exception
     */
    public function index()
    {
        $template = array(
            'module' => $this->module,
            'title' => 'Sporturi',
            'activeMenu' => 'sport_type',
            'method' => __FUNCTION__
        );

        $this->render->addJsUrl(BASE_URL . '/Application/SportType/assets/js/sport_type.js');
        $this->render->setData('template', $template);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/SportType/views/index.html.php'));
        $this->render->renderPage('private.html.php');

        return true;
    }

    /**
     * Returneaza lista cu Sporturi pentru grid
     *
     * @return bool
     * @throws \Exception
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function listSportType()
    {
        $filter = $this->post;
        
        $sportTypeModel = new SportTypeModel();

        $sportTypes = $sportTypeModel->listByFilters($filter);

        foreach ($sportTypes['aaData'] as &$type) {
            $type['status'] = $type['status'] == SportTypeModel::STATUS_ACTIVE ? SportTypeModel::STATUS_ACTIVE_LABEL : SportTypeModel::STATUS_INACTIVE_LABEL;
        }

        $sportTypes["sEcho"] = time();

        $this->jsonResponse($sportTypes);
    }


    /**
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     *
     * @return bool
     * @throws \Exception
     */
    public function add()
    {
        $template = array(
            'module' => $this->module,
            'title' => 'Sporturi',
            'activeMenu' => 'sport_type',
            'method' => __FUNCTION__
        );

        $sportTypeModel = new SportTypeModel();

        if ($this->post) {
            $sportType = $this->post['type'];

            if ($sportTypeModel->validate($sportType)) {
                if (false != $sportTypeModel->saveSportType($sportType)) {
                    $this->response->redirect(BASE_URL . '/sport_type/index');
                } else {
                    Uim::addError('Tipul de sport exista deja.');
                }
            }
            $this->render->setData('type', $sportType);
        }

        $this->render->addJsUrl(BASE_URL . '/Application/SportType/assets/js/add_edit.js');
        $this->render->setData('op', 'add');
        
        $this->render->setData('template', $template);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/SportType/views/add_edit.html.php'));
        $this->render->renderPage('private.html.php');

        return true;
    }

    /**
     * Editeaza datele
     *
     * @param $sportTypeId
     * @return bool
     * @throws \Exception
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function edit($sportTypeId)
    {
        $template = array(
            'module' => $this->module,
            'title' => 'Sporturi',
            'activeMenu' => 'sport_type',
            'method' => __FUNCTION__
        );

        $sportTypeModel = new SportTypeModel();
        
        $type = $sportTypeModel->getByID($sportTypeId);

        if ($this->post) {
            $type['name'] = $this->post['type']['name'];
            $type['status'] = $this->post['type']['status'];

            if ($sportTypeModel->validate($type)) {
                $sportTypeModel->editSportType($type);
                $this->response->redirect(BASE_URL . '/sport_type/index');
            }

            $this->render->setData('type', $type);
        }


        $this->render->addJsUrl(BASE_URL . '/Application/SportType/assets/js/add_edit.js');

        $this->render->setData('op', 'edit');
        $this->render->setData('template', $template);
        $this->render->setData('type', $type);

        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/SportType/views/add_edit.html.php'));
        $this->render->renderPage('private.html.php');

        return true;
    }

    /**
     * Delete sport type by id
     * 
     * @return bool
     */
    public function delete()
    {
        $sportTypeId = $this->post['sport_type_id'];

        $sportTypeModel = new SportTypeModel();
        $sportTypeModel->deleteSportType($sportTypeId);

        $response = new Response();
        $response->endJson(array('status' => Response::JSON_OK, 'message' => ''));
    }
}