<?php

namespace Application\AdminAuthentication;

use SportArea\Core\Uim;
use SportArea\Core\Validate;
use Application\Users\UsersModel;

/**
 * Modul pentru autentificare utilizator
 * 
 * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
 */
class AdminAuthenticationController extends \SportArea\Core\Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->response->redirect(BASE_URL . '/admin/login');
    }

    /**
     * Pagina de login utilizator
     *
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function login()
    {
        $template = array(
            'title' => 'Logarea',
        );

        $usersModel = new UsersModel();

        // Check if user is allready logged in
        if ($usersModel->checkBrowserCredentials()) {
            $this->response->redirect(BASE_URL . '/dashboard/index');
        }

        if ($this->post) {

            // Validate the form
            isset($this->post['email']) ? Validate::email($this->post['email'], 'E-mailul trebuie completat/valid.', 1) : Uim::addError('Adresa de e-mail trebuie completata.');
            isset($this->post['password']) ? Validate::string($this->post['password'], 'Parola trebuie completata.', 1) : $this->flash->error('Parola trebuie completata.');

            // If we have no errors so far
            if (!Uim::haveErrors()) {

                /**
                 *   0 : wrong email+password
                 *   1 : good email+password
                 * 101 : account pending
                 * 102 : account suspended
                 * 201 : user pending
                 * 202 : user suspended
                 */
                $user   = array();
                $status = $usersModel->validateCredentials($this->post['email'], $this->post['password'], $user);

                // Successfully logged in
                if ($status === 1) {

                    // Set browser credentials (session and cookies)
                    $usersModel->setBrowserCredentials($user, $this->post);
                    $this->response->redirect(BASE_URL . '/dashboard/index');

                    // Wrong email+password
                } else if ($status == 0) {
                    // TODO: add in logs
                    Uim::addError('Datele de logare (e-mail/parola) sunt incorecte.');
                    // Pending user
                } else if ($status == 201) {
                    Uim::addError('Acest utilizator nu este activat.');

                    // Suspended user
                } else if ($status == 202) {
                    Uim::addError('Acest utilizator este suspendat.');
                }
            }
        }

        $this->render->addJsUrl(BASE_URL . '/Application/AdminAuthentication/assets/js/login.js');
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/AdminAuthentication/views/login.html.php'));
        $this->render->setData('template', $template);
        $this->render->renderPage('public.html.php');
        return true;
    }

    /**
     * Logout a logged user
     *
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function logout()
    {
        $usersModel = new UsersModel();
        if ($usersModel->logout()) {
            Uim::addMessage('Delogare reusita.');
        } else {
            Uim::addError('Delogare esuata.');
        }

        $this->response->redirect(BASE_URL . '/admin/login');
    }

}
