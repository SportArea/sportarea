<?php

namespace Application\Profile;

use SportArea\Core\Access;
use SportArea\Core\Uim;
use SportArea\Core\Response;
use Application\Users\UsersModel;
use Application\AssignedRoles\AssignedRolesModel;
use Application\Roles\RolesModel;

class ProfileController extends Access
{

    protected $module = 'profile';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Edit user profile page
     *
     * @author  Norbert Hegedus <norbert.hegedus@yahoo.ro>
     */
    public function index()
    {
        $template = array(
            'module'     => $this->module,
            'title'      => 'Profil',
            'activeMenu' => 'profile',
            'method'     => __FUNCTION__
        );

        $usersModel    = new UsersModel();
        $assignedRoles = new AssignedRolesModel();
        $roelesModel   = new RolesModel();

        $userId           = $this->loggedUser['id'];
        $user             = $usersModel->getByID($userId);
        $userAssignedRole = $assignedRoles->getBy(array(), array('user_id' => $userId));
        $userRole         = $roelesModel->getByID(isset($userAssignedRole[0]['role_id']) ? $userAssignedRole[0]['role_id'] : 0);

        if ($this->post) {
            $user['first_name'] = $this->post['user']['first_name'];
            $user['last_name']  = $this->post['user']['last_name'];
            $user['email']      = $this->post['user']['email'];

            if ($usersModel->validate($user)) {
                if (false == $usersModel->isEmailAssigned($user['email'], $userId)) {
                    if (false == $usersModel->editUser($user)) {
                        Uim::addError('Eroare la salvarea datelor!');
                    } else {
                        Uim::addMessage('Modificarile au fost salvate cu succes!');
                    }
                } else {
                    Uim::addError('Emailul a fost asignat la un alt utilizator.');
                }
            }
        }

        $this->render->addCss(BASE_URL . '/Application/Profile/assets/css/profile.css');
        $this->render->addJsUrl(BASE_URL . '/Application/Profile/assets/js/edit_profile.js');

        $this->render->setData('template', $template);
        $this->render->setData('user', $user);
        $this->render->setData('userRole', $userRole);

        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Profile/views/index.html.php'));
        $this->render->renderPage('private.html.php');

        return true;
    }

    /**
     * User change password
     *
     * @author Norbert Hegedus <norbert.hegedus@yahoo.ro>
     */
    public function changePassword()
    {
        $ajaxResponse['status'] = Response::JSON_FAIL;
        $userEmail              = $this->loggedUser['email'];
        $usersModel             = new UsersModel();
        $user                   = array();
        $status                 = $usersModel->validateCredentials($userEmail, $this->post['old_password'], $user);

        // Successfully match the old password
        if ($status === 1) {
            $ajaxResponse['status'] = Response::JSON_OK;
            $user['id']             = $this->loggedUser['id'];
            $user['salt']           = $usersModel->newSalt();
            $user['password']       = $usersModel->generatePassword($this->post['new_password'], $user['salt']);
            $usersModel->saveUser($user);

            // Wrong old password
        } else if ($status == 0) {
            $ajaxResponse['message'] = 'Parola veche este incorecta.';
            // Suspended user
        } else if ($status == 201) {
            $ajaxResponse['message'] = 'Acest utilizator nu este activ.';
        }

        $response = new Response();
        $response->endJson($ajaxResponse);
    }

}
