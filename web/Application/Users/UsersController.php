<?php

namespace Application\Users;

// Core
use SportArea\Core\Access;
use SportArea\Core\Response;
use SportArea\Core\Uim;
use SportArea\Core\Validate;
use SportArea\Core\Utils;
use SportArea\Core\Email;
use SportArea\Core\System;

// Application
use Application\Users\UsersModel;
use Application\Settings\SettingsModel;
use Application\Roles\RolesModel;
use Application\AssignedRoles\AssignedRolesModel;


/**
 */
class UsersController extends Access
{
    protected $module = 'users';

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
            'title' => 'Utilizatori',
            'activeMenu' => 'settings',
            'method' => __FUNCTION__
        );

        $this->render->addJsUrl(BASE_URL . '/Application/Users/views/js/users.js');
        $this->render->setData('template', $template);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Users/views/index.html.php'));
        $this->render->renderPage('private.html.php');

        return true;
    }

    /**
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function listUsers()
    {
        $filter = $this->post;
        $this->setSessionFilter($filter);

        $usersModel = new UsersModel();
        $users = $usersModel->listByFilters($filter);

        foreach ($users['aaData'] as &$user) {
            $user['name'] = $user['first_name'] . ' ' . $user['last_name'];
        }

        $users["sEcho"] = time();

        $this->jsonResponse($users);
    }

    private function setSessionFilter($filter)
    {

    }

    /**
     * Update logged user credentials
     *
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function credensials()
    {
        $template = array(
            'title' => 'Date de access',
            'activeMenu' => null,
            'method' => \SportArea\Core\Utils::camelCaseToLowerCase(__FUNCTION__)
        );

        // Users
        $UsersModel = new UsersModel();
        $user = $UsersModel->getByID($this->loggedUser['id']);

        if ($this->post) {
            if (!$UsersModel->validateCredentials($user['email'], $this->post['password'], $user)) {
                Uim::addError('Parola curenta trebuie completata.');
            }

            if (Validate::password($this->post['new_password'], 'Parola noua trebuie sa contina cel putin 10 caractere, sa aibe in componenta cel putin o litera mare, cel putin o cifra si cel putin un caracter special (!@#$%^&*+=).')) {
                Validate::equal($this->post['new_password'], $this->post['repeat_new_password'], 'Parola noua si comfirmarea ei nu sunt identice.');
            }

            // No errors here
            if (!Uim::haveErrors()) {
                if ($UsersModel->save(array(
                    'id' => $user['id'],
                    'password' => $UsersModel->generatePassword($this->post['password'], $user['salt'])
                ))
                ) {
                    Uim::addMessage('Parola a fost schimbata.');
                } else {
                    Uim::addMessage('Parola nu a putut fi schimbata.');
                }
            }

            $this->response->redirect(BASE_URL . '/users/credensials');
        }

        $this->render->setData('template', $template);
        $this->render->setData('user', $user);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Users/views/my_profile_credensials.html.php'));
        $this->render->renderPage('private.html.php');
        return true;
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
            'title' => 'Utilizatori',
            'activeMenu' => 'settings',
            'method' => 'users'
        );

        $userModel = new UsersModel();

        if ($this->post) {
            $user = $this->post['user'];
            $user['salt'] = $userModel->newSalt();
            $user['password'] = $userModel->generatePassword($user['password'], $user['salt']);
            $userRole = $user['role'];
            unset($user['role']);

            if ($userModel->validate($user)) {
                if (false == $userModel->isEmailAsigned($user['email'])) {
                    if (true == $userModel->saveUser($user, $userRole)) {
                        $this->response->redirect(BASE_URL . '/users/index');
                    } else {
                        Uim::addError('Emailul a fost asignat la un alt utilizator.');
                    }
                } else {
                    Uim::addError('Emailul a fost asignat la un alt utilizator.');
                }
            }

            $this->render->setData('user', $user);
        }

        $this->render->addJsUrl(BASE_URL . '/Application/Users/views/js/add_edit.js');
        $this->render->setData('op', 'add');
        $this->render->setData('template', $template);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Users/views/add_edit.html.php'));
        $this->render->renderPage('private.html.php');

        return true;
    }

    /**
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     *
     * @return bool
     * @throws \Exception
     */
    public function edit($userId)
    {
        $template = array(
            'module' => $this->module,
            'title' => 'Utilizatori',
            'activeMenu' => 'settings',
            'method' => 'users'
        );

        $usersModel = new UsersModel();
        $user = $usersModel->getByID($userId);
        $rolesModel = new RolesModel();
        $role = $rolesModel->getRolsForUser($userId);
        $roleId = array_keys($role);
        $user['role'] = $roleId[0];

        if ($this->post) {
            $user['first_name'] = $this->post['user']['first_name'];
            $user['last_name'] = $this->post['user']['last_name'];
            $user['email'] = $this->post['user']['email'];
            $user['status'] = $this->post['user']['status'];
            $user['role'] = $this->post['user']['role'];
            $userRole = $user['role'];
            unset($user['role']);

            if ($usersModel->validate($user)) {
                if (false == $usersModel->isEmailAsigned($user['email'], $userId)) {
                    if (true == $usersModel->editUser($user, $userRole)) {
                        $this->response->redirect(BASE_URL . '/users/index');
                    } else {
                        Uim::addError('Emailul a fost asignat la un alt utilizator.');
                    }
                } else {
                    Uim::addError('Emailul a fost asignat la un alt utilizator.');
                }
            }

            $this->render->setData('user', $user);
        }

        $this->render->addJsUrl(BASE_URL . '/Application/Users/views/js/add_edit.js');

        $this->render->setData('template', $template);
        $this->render->setData('user', $user);
        $this->render->setData('op', 'edit');
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Users/views/add_edit.html.php'));
        $this->render->renderPage('private.html.php');

        return true;
    }

    /**
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     *
     * @return bool
     * @throws \Exception
     */
    public function delete()
    {
        $ajaxResponse['status'] = Response::JSON_FAIL;

        $userId = $this->post['user_id'];

        $userModel = new UsersModel();
        $userModel->deleteUser($userId);

        return true;
    }

    /**
     * Reset a user password
     *
     * @param   integer $userID
     */
    public function resetPassword($userID)
    {

        $userID = abs(intval($userID));
        $UsersModel = new UsersModel();
        $user = $UsersModel->getByID($userID);

        if (!Validate::isArray($user, null, 1)) {
            // TODO: log this
            Uim::addError('Utilizatorul caruia vrei să îi resetezi parola nu există.');

        } else if (Validate::isArray($user, null, 1) && ($user['deleted'] || in_array($user['status'], array(UsersModel::STATUS_PENDING, UsersModel::STATUS_SUSPENDED)))) {
            // TODO: log this
            Uim::addError('Parola utilizatorului nu poate fi resetata.');

        } else if (Validate::isArray($user, null, 1) && ($user['account_id'] != $this->loggedUser['account_id'] || $user['id'] == $this->loggedUser['id'])) {
            // TODO: log this
            Uim::addError('Utilizatorul caruia vrei să îi resetezi parola nu aparține contului tau.');

        } else {

            $newSalt = $UsersModel->newSalt();
            $newPlainTextPassword = Utils::randomString(12, array(
                'abcdefghijklmnopqrstuwxyz',
                'ABCDEFGHIJKLMNOPQRSTUWXYZ',
                '0123456789',
                '!@#$%^&*+'
            ));
            $newPassword = $UsersModel->generatePassword($newPlainTextPassword, $newSalt);

            if ($UsersModel->save(array(
                'id' => $user['id'],
                'salt' => $newSalt,
                'password' => $newPassword
            ))
            ) {
                Uim::addMessage(sprintf('Parola utilizatorului <b>%1$s %2$s</b> a fost resetata.', $user['first_name'], $user['last_name']));
                $Email = new Email();
                if ($Email->send($user['email'], 'SportArea - Event manager - Resetare parola', 'Parola ta a fost resetata.<br />Noua parola este: ' . $newPlainTextPassword)) {
                    Uim::addMessage(sprintf('Noua parola a fost trimisa pe e-mailul <b>%1$s</b>.', $user['email']));
                } else {
                    Uim::addError('Noua parola nu a putut fi trimisa pe e-mail.');
                }

                if (SettingsModel::get('environment') == 'development') {
                    Uim::addMessage(sprintf('<b>DEV:</b> Noua parola a utilizatorului este <b>%s</b>', $newPlainTextPassword));
                }

            } else {
                Uim::addError('Parola utilizatorului %1$s %2$s nu a putut fi resetata.', $user['first_name'], $user['last_name']);
            }
        }

        $this->response->redirect(BASE_URL . '/users/index');
    }



}