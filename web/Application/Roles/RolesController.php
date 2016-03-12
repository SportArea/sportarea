<?php

namespace Application\Roles;

use Application\Modules\ModulesModel;
use Application\Roles\RolesModel;
use Application\RolesInModules\RolesInModulesModel;
use Application\AssignedRoles\AssignedRolesModel;

use SportArea\Core\Uim;
use SportArea\Core\Validate;

class RolesController extends \SportArea\Core\Access
{
    public $module = 'roles';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     */
    public function roles()
    {
        if($this->loggedUser['account_type'] != \Application\Roles\RolesModel::ROLE_SUPERADMIN) {
            Uim::addErrorAndRedirect('Nu aveți drepturi de acces pentru pagina solicitată.', BASE_URL);
        }

        // If not superadmin, or doesn't have right for this method
        if(in_array('Superadmin', $this->loggedUser['roles'])) {
            $this->response->redirect(BASE_URL.'/roles/global_roles');
        }

        ########################################################################################################################################################
        ########################################################################################################################################################

        $template = array(
            'title'         => 'Roluri globale',
            'activeMenu'    => 'settings',
            'method'        => \SportArea\Core\Utils::camelCaseToLowerCase(__FUNCTION__)
        );

        $ModulesModel           = new ModulesModel();
        $RolesModel             = new RolesModel();
        $RolesInModulesModel    = new RolesInModulesModel();

        ########################################################################################################################################################
        ###  POST   ############################################################################################################################################

        if($this->post) {
            // Delete all assigned global roles
            $RolesInModulesModel->deleteAllByAccountID($this->loggedUser['account_id']);

            foreach ($this->post['rolesInModules'] as $roleID => $modules) {
                // Check if user try to change somebody else's roles
                if(Validate::isArray($RolesModel->getBy(array(), array('id' => $roleID, 'account_id' => $this->loggedUser['account_id'])), null, 1)) {
                    foreach ($modules as $moduleID => $value) {
                        $RolesInModulesModel->save(array(
                            'role_id'   =>  $roleID,
                            'module_id' =>  $moduleID
                        ));
                    }
                } else {
                    // TODO: send email to super admin
                    // TODO: log this
                }
            }

            if(!Uim::haveErrors()) {
                Uim::addMessage('Rolurile au fost salvate. Acestea vor intra in vigoare doar dupa urmatoarea logare a utilizatorilor.');
            }
        }

        ########################################################################################################################################################
        ########################################################################################################################################################

        $roles          = $RolesModel->getGlobalAndAccountRoles($this->loggedUser['account_id']);
        $modules        = $ModulesModel->getBy(array(), array('module_id' => 'IS NULL'));

        foreach ($modules as $moduleIndex => $module) {
            $modules[$moduleIndex]['submodules'] = $ModulesModel->getBy(array(), array('module_id' => $module['id']));
        }

        $rolesInModules = $RolesInModulesModel->getBy();

		$rolesInModulesCompact = array();
		foreach ($rolesInModules as $roleInModule) {
			$rolesInModulesCompact[] = $roleInModule['role_id'].'_'.$roleInModule['module_id'];
		}

        $this->render->setData('template', $template);
        $this->render->setData('roles', $roles);
        $this->render->setData('modules', $modules);
        $this->render->setData('rolesInModulesCompact', $rolesInModulesCompact);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Roles/views/roles.html.php'));
        $this->render->renderPage('private.html.php'); return true;
    }

    /**
     * Add a new role for an account
     *
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function add()
    {
        if($this->loggedUser['account_type'] != \Application\Roles\RolesModel::ROLE_SUPERADMIN) {
            Uim::addErrorAndRedirect('Nu aveți drepturi de acces pentru pagina solicitată.', BASE_URL);
        }

        if($this->post) {
            if(Validate::string($this->post['name'], 'Numele rolului nu a fost completat.', 1)) {
                $RolesModel = new RolesModel();
                if($RolesModel->save(array(
                    'name'          =>  $this->post['name'],
                    'account_id'    =>  $this->loggedUser['account_id']
                ))) {
                    Uim::addMessage('Rolul a fost adaugat.');
                } else {
                    Uim::addError('Rolul nu a putut fi adaugat.');
                }
            }
        } else {
            Uim::addError('Numele rolului nu a fost compeltat.');
        }

        $this->response->redirect(BASE_URL.'/roles/roles');
    }

    /**
     * Delete an account role by ID
     *
     * @param   integer $roleID
     */
    public function delete($roleID)
    {
        if($this->loggedUser['account_type'] != \Application\Roles\RolesModel::ROLE_SUPERADMIN) {
            Uim::addErrorAndRedirect('Nu aveți drepturi de acces pentru pagina solicitată.', BASE_URL);
        }
        
        // Get role by id
        $RolesModel = new RolesModel();
        $roles = $RolesModel->getBy(array(), array('id' => $roleID, 'account_id' => $this->loggedUser['account_id']));

        // If the role exists
        if(Validate::isArray($roles, null, 1)) {

            $role = $roles[0];

            // Delete all from roles in modules
            $RolesInModulesModel = new RolesInModulesModel();
            $RolesInModulesModel->deleteByParams(array('role_id' => $role['id']));

            // Delete all from assigned roles
            $AssignedRolesModel = new AssignedRolesModel();
            $AssignedRolesModel->deleteByParams(array('role_id' => $role['id']));

            // Delete the role
            $RolesModel->deleteByID($role['id']);

            Uim::addMessage('Rolul a fost sters impreuna cu toate asocierile cu module si utilizatori.');

        } else {
            Uim::addError('Rolul pe care doriti sa il stergeti nu există.');
        }

        $this->response->redirect(BASE_URL.'/roles/roles');
    }

    /**
     * @author  Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function globalRoles()
    {
        // If not superadmin, or doesn't have right for this method
        if(!in_array('Superadmin', $this->loggedUser['roles'])) {
            Uim::addError('Nu aveți drepturi de acces pentru pagina solicitată.');
            $this->response->redirect(BASE_URL.'/dashboard/index');
        }

        ########################################################################################################################################################
        ########################################################################################################################################################

        $template = array(
            'title'         => 'Roluri globale',
            'activeMenu'    => 'settings',
            'method'        => \SportArea\Core\Utils::camelCaseToLowerCase(__FUNCTION__)
        );

        $ModulesModel           = new ModulesModel();
        $RolesModel             = new RolesModel();
        $RolesInModulesModel    = new RolesInModulesModel();

        ########################################################################################################################################################
        ###  POST   ############################################################################################################################################

        if($this->post) {
            // Delete all assigned global roles
            $RolesInModulesModel->deleteAllGlobal();

            foreach ($this->post['rolesInModules'] as $roleID => $modules) {
                foreach ($modules as $moduleID => $value) {
                    $RolesInModulesModel->save(array(
                        'role_id'   =>  $roleID,
                        'module_id' =>  $moduleID
                    ));
                }
            }

            Uim::addMessage('Rolurile globale au fost salvate. Acestea vor intra in vigoare doar dupa urmatoarea logare a utilizatorilor.');
        }

        ########################################################################################################################################################
        ########################################################################################################################################################

        $roles          = $RolesModel->getBy(array(), array('account_id' => 'IS NULL'));
        $modules        = $ModulesModel->getBy(array(), array('module_id' => 'IS NULL'));

        foreach ($modules as $moduleIndex => $module) {
            $modules[$moduleIndex]['submodules'] = $ModulesModel->getBy(array(), array('module_id' => $module['id']));
        }

        $rolesInModules = $RolesInModulesModel->getBy();

		$rolesInModulesCompact = array();
		foreach ($rolesInModules as $roleInModule) {
			$rolesInModulesCompact[] = $roleInModule['role_id'].'_'.$roleInModule['module_id'];
		}

        $this->render->setData('template', $template);
        $this->render->setData('roles', $roles);
        $this->render->setData('modules', $modules);
        $this->render->setData('rolesInModulesCompact', $rolesInModulesCompact);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Roles/views/roles.html.php'));
        $this->render->renderPage('private.html.php'); return true;
    }
}