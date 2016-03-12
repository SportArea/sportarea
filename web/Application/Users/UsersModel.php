<?php

namespace Application\Users;

use Application\AssignedRoles\AssignedRolesModel;
use Application\Roles\RolesModel;
use SportArea\Core\Validate;
use SportArea\Core\Model;
use SportArea\Core\Utils;

class UsersModel extends Model
{
    protected $table = 'users';

    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';

    public function __construct()
    {
        parent::__construct();
    }

    public function table()
    {
        return array(
            'id' => array(
                'i18n' => array('RO-RO' => 'ID'),
                'rules' => array(Model::V_INTEGER_UNSIGNED)
            ),

            'first_name' => array(
                'i18n' => array('RO-RO' => 'Nume'),
                'rules' => array(Model::V_REQUIRED)
            ),

            'last_name' => array(
                'i18n' => array('RO-RO' => 'Prenume'),
                'rules' => array(Model::V_REQUIRED)
            ),

            'email' => array(
                'i18n' => array('RO-RO' => 'E-mail'),
                'rules' => array(Model::V_REQUIRED, Model::V_EMAIL)
            ),

            'password' => array(
                'i18n' => array('RO-RO' => 'Parola'),
                'rules' => array(Model::V_REQUIRED)
            ),

            'salt' => array(
                'i18n' => array('RO-RO' => 'SALT'),
                'rules' => array(Model::V_REQUIRED)
            ),

            'status' => array(
                'i18n' => array('RO-RO' => 'Stare'),
                'rules' => array(Model::V_REQUIRED, Model::V_REGEXP => '/^(' . UsersModel::STATUS_ACTIVE . '|' . UsersModel::STATUS_SUSPENDED . ')$/')
            ),

            'deleted' => array(
                'i18n' => array('RO-RO' => 'Sters'),
                'rules' => array(Model::V_BOOLEAN)
            ),
        );
    }


    /**
     * Save user data
     *
     * @param array $user
     */
    public function saveUser(array $user, $userRole = 0)
    {
        try {
            $userId = $this->save($user);
        } catch (\PDOException $e) {
            return false;
        }

        if ($userRole != 0) {
            $userInRoles = new AssignedRolesModel();
            $userInRolesData['user_id'] = $userId;
            $userInRolesData['role_id'] = $userRole;

            $userInRoles->save($userInRolesData);
        }
        return true;
    }

    /**
     * Save user data
     *
     * @param array $user
     */
    public function editUser(array $user, $userRole)
    {
        foreach ($user as $key => $userData) {
            if (!in_array($key, array('id', 'first_name', 'last_name', 'email', 'status'))) {
                unset($user['key']);
            }
        }

        try {
            $userId = $this->save($user);
        } catch (\PDOException $e) {
            return false;
        }

        $userInRoles = new AssignedRolesModel();
        $userInRolesData['user_id'] = $userId;
        $userInRolesData['role_id'] = $userRole;

        try {
            $userInRoles->updateUserRole($userInRolesData);
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }

    /**
     * Delete user by id
     *
     * @param $userId
     * @return bool
     */
    public function deleteUser($userId)
    {
        $query = "UPDATE `users` SET `deleted` = 1 WHERE `users`.`id` = :userId";

        $whereParams['userId'] = $userId;

        $results = $this->exec($query, $whereParams);

        return true;
    }

    /**
     * Verify if email is already asigned to another user
     *
     * @param $email
     * @return bool
     */
    public function isEmailAsigned($email, $userId = 0)
    {

        $query = "
            SELECT COUNT(`" . $this->table . "`.`id`) as `nr_user`
            FROM `" . $this->table . "`
            WHERE `" . $this->table . "`.`email` like '" . $email . "'
             AND `" . $this->table . "`.`deleted` = 0";

        if ($userId != 0) {
            $query .= " AND `" . $this->table . "`.`id` <> " . $userId;
        }

        $result = $this->query($query);
        $nr = (int)$result[0]['nr_user'];

        $isUsed = false;
        if ($nr > 0) {
            $isUsed = true;
        }

        return $isUsed;
    }

    /**
     * Edit user profile
     * @param $user
     * @return bool
     */
    public function ediProfile($user) {
        foreach ($user as $key => $userData) {
            if (!in_array($key, array('id', 'first_name', 'last_name', 'email'))) {
                unset($user['key']);
            }
        }

        try {
            $this->save($user);
        } catch (\PDOException $e) {
            return false;
        }

        return true;
    }
    /**
     * List users by filter
     *
     * @param $filter
     * @return mixed
     */
    public function listByFilters($filter)
    {
        $query = "
            SELECT `users`.*
            FROM `users`";

        $filterResult = $this->filter($filter['search']);
        $query .= $filterResult['sql'];

        $whereParams = $filterResult['where'];

        $query = $this->orderBy($query, $filter);
        $query = $this->setPagination($query, $filter);

        $results = $this->query($query, $whereParams);

        $response['aaData'] = $results;
        $response['iTotalRecords'] = (int)$this->countByFilters($filter);
        $response['iTotalDisplayRecords'] = (int)$this->countByFilters($filter);

        return $response;
    }

    /**
     * Build filter query
     *
     * @param $search
     * @return array
     */
    private function filter($search)
    {
        parse_str($search, $filters);


        $whereParams = array();
        $sql = ' WHERE `deleted` = 0';
        $hasWhere = true;

        if (isset($filters['name']) && strlen($filters['name'])) {
            $sql .= (true === $hasWhere) ? " AND " : " WHERE ";
            $sql .= "(`" . $this->table . "`.`first_name` LIKE :name";
            $sql .= " OR `" . $this->table . "`.`last_name` LIKE :name)";

            $whereParams['name'] = '%' . $filters['name'] . '%';
            $hasWhere = true;
        }

        if (isset($filters['email']) && strlen($filters['email'])) {
            $sql .= (true === $hasWhere) ? " AND " : " WHERE ";
            $sql .= "`" . $this->table . "`.`email` LIKE :email";
            $whereParams['email'] = '%' . $filters['email'] . '%';
            $hasWhere = true;
        }

        return array('sql' => $sql, 'where' => $whereParams);
    }


    /**
     * Count number of items returned after filtering
     *
     * @param $filter
     * @return int
     */
    public function countByFilters($filter)
    {
        $query = "
            SELECT COUNT(`users`.`id`) AS `user_count`
            FROM `users`";
        $filterResult = $this->filter($filter['search']);
        $query .= $filterResult['sql'];

        $whereParams = $filterResult['where'];
        $result = $this->query($query, $whereParams);

        return (int)$result[0]['user_count'];
    }

    /**
     * Generate new salt
     *
     * @return  string
     */
    public function newSalt()
    {
        return Utils::randomString(24, array(
            'abcdefghijklmnopqrstuwxyz',
            'ABCDEFGHIJKLMNOPQRSTUWXYZ',
            '0123456789',
        ));
    }

    /**
     * Generate an encrypted password
     *
     * @param   string $plainTextPassword
     * @param   string $salt
     * @return  string
     */
    public function generatePassword($plainTextPassword, $salt)
    {
        return sha1(trim($plainTextPassword) . trim($salt));
    }

    /**
     * Validate a password
     *
     * @param   string $plainTextPassword
     * @param   string $salt
     * @param   string $encryptedPassword
     * @return  boolean
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function validatePassword($plainTextPassword, $salt, $encryptedPassword)
    {
        return ($this->generatePassword($plainTextPassword, $salt) == $encryptedPassword);
    }

    /**
     * Validate an user credensials
     *
     * @param   string $emai
     * @param   string $plainTextPassword
     * @return  mixed:
     *                    0 : wrong email+password
     *                    1 : good email+password
     *                  101 : account pending
     *                  102 : account suspended
     *                  201 : user pending
     *                  202 : user suspended
     *
     */
    public function validateCredentials($email, $plainTextPassword, &$user)
    {
        $users = $this->query("
            SELECT
                `users`.*
            FROM `users`
            WHERE `email` = :email",
            array(
                ':email' => $email
            ));

        if (Validate::isArray($users, null, 1)) {
            $user = $users[0];

            if ($user['status'] == UsersModel::STATUS_ACTIVE) {
                return ($this->validatePassword($plainTextPassword, $user['salt'], $user['password'])) ? 1 : 0;
            } else if ($user['status'] == UsersModel::STATUS_SUSPENDED) {
                return 201;
            }
        } else {
            return false;
        }
    }

    /**
     * @param    integer $userID
     * @return    array
     * @author    Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function userInModules($userID = 0)
    {
        $module = $this->query("
									SELECT
                                        `modules`.`id`,
                                        `modules`.`table`
									FROM `assigned_roles`
									JOIN `roles` ON `assigned_roles`.`role_id` = `roles`.`id`
									JOIN `roles_in_modules` ON `roles_in_modules`.`role_id` = `roles`.`id`
									JOIN `modules` ON `modules`.`id` = `roles_in_modules`.`module_id`
									WHERE `assigned_roles`.`user_id` = :user_id
									GROUP BY `modules`.`name`
									", array(':user_id' => $userID));

        $return = array();
        foreach ($module as $modul) {
            $return[$modul['id']] = $modul['table'];
        }

        return $return;
    }

    /**
     * Set browser session/cookies when an user is logged in
     *
     * @param   array $user
     */
    public function setBrowserCredentials($user, $postRequest = array())
    {
        $RolesModel = new RolesModel();

        $user['roles'] = $RolesModel->getRolsForUser($user['id']);
        $user['modules'] = $this->userInModules($user['id']);
        $this->session->set('loggedUser', $user);

        // Remember me
        if (is_array($postRequest) && isset($postRequest['remember']) && $postRequest['remember'] == 1) {

            // Cookie expiry time, based on global settings
            $expiry = (time() + SETTINGS_REMEMBER_COOKIE_LIFETIME);

            // Compute cookie array
            $cookie = array(
                'id' => $user['id'],
                'email' => $user['email'],
                'expiry' => $expiry,
                'validationKey' => sha1(SALT . $user['id'] . $user['email'] . $expiry),
                'authKey' => sha1(SALT . $user['id'] . $user['email'] . $user['password'] . $user['salt'])
            );

            // Save the cookie
            $this->cookie->set('loggedUser', json_encode($cookie), $expiry);
        }
    }

    /**
     * Check browser credensials, if user is logged in (session) or has cookie
     *
     * @author Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public function checkBrowserCredentials()
    {
        // Session
        if (Validate::isArray($this->loggedUser, null, 1)) {
            // TODO: log this
            return true;

            // Cookie
        } else if (Validate::json($this->cookie->get('loggedUser'))) {
            $loggedUserCookie = json_decode($this->cookie->get('loggedUser'), true);

            // Invalid validationKey
            if ($loggedUserCookie['validationKey'] != sha1(SALT . $loggedUserCookie['id'] . $loggedUserCookie['email'] . $loggedUserCookie['expiry'])) {
                // TODO: log this
                $this->cookie->delete('loggedUser');
                return false;
            }

            // Expired cookie
            if (time() > $loggedUserCookie['expiry']) {
                // TODO: log this
                $this->cookie->delete('loggedUser');
                return false;
            }

            // Get user by ID and e-mail
            $users = $this->getBy(array(), array('id' => $loggedUserCookie['id'], 'email' => $loggedUserCookie['email']));

            // Inexistent user
            if (!Validate::isArray($users, null, 1)) {
                // TODO: log this
                $this->cookie->delete('loggedUser');
                return false;
            }

            $user = $users[0];

            //\SportArea\Core\Utils::printR($user, true);

            // Invalid authKey
            if ($loggedUserCookie['authKey'] != sha1(SALT . $user['id'] . $user['email'] . $user['password'] . $user['salt'])) {
                // TODO: log this
                $this->cookie->delete('loggedUser');
                return false;
            }

            // Not active user
            if ($user['status'] != UsersModel::STATUS_ACTIVE) {
                // TODO: log this
                $this->cookie->delete('loggedUser');
                return false;
            }


            // TODO: log this (successfully logged in with cookie)

            \SportArea\Core\Uim::clear();
            $this->setBrowserCredentials($user, array());
            return true;
        }

        return false;
    }

    /**
     * Delete logged user session and cookie
     *
     * @return  boolean
     */
    public function logout()
    {
        $session = $this->session->delete('loggedUser');
        $cookie = $this->cookie->delete('loggedUser');

        if ($session || $cookie) {
            return true;
        } else {
            return false;
        }
    }


    public function changeAvatar($userArray, $fileArray)
    {
        $userDirectory = ROOT . '/repository/accounts/' . $userArray['account_id'] . '/users/' . $userArray['id'];
        $uploadedFile = md5(microtime()) . '.' . pathinfo(basename($fileArray['name']), PATHINFO_EXTENSION);

        if (!is_dir($userDirectory)) {
            if (!mkdir($userDirectory)) {
                // TODO: add log
                return false;
            }
        }

        if (move_uploaded_file($fileArray['tmp_name'], $userDirectory . '/' . $uploadedFile)) {

            if (!empty($userArray['profile_image']) && file_exists($userDirectory . '/' . $userArray['profile_image'])) {
                unlink($userDirectory . '/' . $userArray['profile_image']);
            }

            // Resize image to a maximum size
            $ImageResize = new ImageResize($userDirectory . '/' . $uploadedFile);
            $ImageResize->resizeTo(450, 450, 'default');
            $ImageResize->saveImage($userDirectory . '/' . $uploadedFile);

            $this->save(array(
                'id' => $userArray['id'],
                'profile_image' => $uploadedFile
            ));

            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * @param   integer $userID
     * @author  Norbert Hegedus <hegedus.norbert@yahoo.ro>
     */
    public static function getAvatar($userID, $returnLargeIfNoAvatar = false)
    {
        $that = new UsersModel();

        $user = $that->getByID($userID);
        $defaultImage = ($returnLargeIfNoAvatar) ? BASE_URL . '/assets/img/user.png' : BASE_URL . '/assets/img/user_small.png';

        if (!Validate::isArray($user, null, 1) || (Validate::isArray($user, null, 1) && empty($user['profile_image']))) {
            return $defaultImage;

        } else {
            $file = 'repository/accounts/' . $user['account_id'] . '/users/' . $user['id'] . '/' . $user['profile_image'];

            if (file_exists(ROOT . '/' . $file)) {
                return BASE_URL . '/' . $file;
            } else {
                return $defaultImage;
            }
        }
    }

}