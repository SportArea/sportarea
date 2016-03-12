<?php

namespace Application\Settings;

// Core
use SportArea\Core\Access;
use SportArea\Core\Uim;

class SettingsController extends Access
{
    protected $module = 'settings';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Account settings
     * This method is ONLY for account. Every account should be able to save its own settings with this method
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Setari pentru conturi
     * Aceasta metoda este DOAR pentru conturi. Fiecare cont in parte ar trebui sa-si poata salva setarile proprii
     *
     */
    public function settings()
    {
        // If not superadmin, or doesn't have right for this method
        if(in_array('Superadmin', $this->loggedUser['roles'])) {
            $this->response->redirect(BASE_URL.'/settings/global_settings');
        }

        ########################################################################################################################################################
        ########################################################################################################################################################

        $template = array(
            'title'         => 'Setari',
            'activeMenu'    => 'settings',
            'method'        => __FUNCTION__
        );

        $SettingsCategoriesModel    = new SettingsCategoriesModel();
        $SettingsModel              = new SettingsModel();

        ########################################################################################################################################################
        ###  POST   ############################################################################################################################################

        if($this->post) {

            $errors		= 0;
            $success	= 0;

            // Get all settings
            $settings = $SettingsModel->getBy(array(), array('account_id' => $this->loggedUser['account_id']));

            foreach ($settings as $setting) {
                // Daca valoarea setarii este diferita de cea din baza de date
                if( key_exists($setting['setting'], $this->post) AND $setting['value'] != $this->post[$setting['setting']] ) {
                    switch ($setting['type']) {

                        // Integer
                        case 'integer':
                            Validate::integer($this->post[$setting['setting']], sprintf('Setarea %1$s trebuie sa fie numar intreg pozitiv.', "<b>{$setting['titlu']}</b>"), 1);
                            break;

                        // Float
                        case 'float':
                            Validate::flaot($this->post[$setting['setting']], sprintf('Setarea %1$s trebuie sa fie numar float (cu punct) pozitiv.', "<b>{$setting['titlu']}</b>"), 1);
                            break;

                        // Multi-checkbox
                        case 'checkbox':
                            $this->post[$setting['setting']] = json_encode($this->post[$setting['setting']]);
                            break;
                    }

                    if(Uim::countErors() == $errors) {
                        $SettingsModel->save(array('id' => $setting['id'], 'value' => $this->post[$setting['setting']]));
                        ++$success;
                    } else {
                        $errors += Uim::countErors();
                    }
                }
            }

            if($success > 0) {
                if($success == 1) {
                    Uim::addMessage('O setare a fost modificatea.');
                } else {
                    Uim::addMessage(sprintf('Un numar de %1$s setari au fost modificate.', $success));
                }

                //LoguriLoguriModel::add(LoguriLoguriModel::ACTIUNE_UPDATE, 'A modificat una sau mai multe setari.');

            } else if($success == 0 AND $errors == 0) {
                Uim::addWarning('Nici o setare nu a fost modificata.');
            }

        }

        ########################################################################################################################################################
        ########################################################################################################################################################

        // Get all settings categories
        $settingsCategories = $SettingsCategoriesModel->getBy();

        $settings = array();
        foreach ($settingsCategories as $key => $category) {
            $settings[$category['name']] = $SettingsModel->getBy(array(), array('category_id' => $category['id'], 'account_id' => $this->loggedUser['account_id']), array(), array(), null, false);
        }

        //\SportArea\Core\Utils::printR($settings, true);

        // Remove empty categories
        $settings = array_filter(array_map('array_filter', $settings));

        $this->render->setData('template', $template);
        $this->render->setData('settings', $settings);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Settings/views/settings.html.php'));
        $this->render->renderPage('private.html.php'); return true;
    }

    /**
     * Global setttings method
     * !!! ONLY SUPER ADMIN SHOULD ACCESS THIS METHOD
     * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     * Setari globale
     * !!! DOAR SUPER ADMINUL AR TREBUI SA POATA ACCESA ACEASTA METODA
     *
     */
    public function globalSettings()
    {

        // If not superadmin, or doesn't have right for this method
        if(!in_array('Superadmin', $this->loggedUser['roles'])) {
            Uim::addError('Nu aveți drepturi de acces pentru pagina solicitată.');
            $this->response->redirect(BASE_URL.'/dashboard/index');
        }

        ########################################################################################################################################################
        ########################################################################################################################################################

        $template = array(
            'title'         => 'Setari',
            'activeMenu'    => 'settings',
            'method'        => \SportArea\Core\Utils::camelCaseToLowerCase(__FUNCTION__)
        );

        $SettingsCategoriesModel    = new SettingsCategoriesModel();
        $SettingsModel              = new SettingsModel();

        ########################################################################################################################################################
        ###  POST   ############################################################################################################################################

        if($this->post) {

            $errors		= 0;
            $success	= 0;

            $cacheContent = "<?php\n\n\n\n/**\n\n\tFISIER GENERAT AUTOMAT ATUNCI CAND SE SALVEAZA SETARILE DIN APLICATIE \n\n\tA NU SE MODIFICA MANUAL\n\n**/\n\n\n\n\n";

            // Get all settings
            $settings = $SettingsModel->getBy(array(), array('account_id' => 'IS NULL'));

            foreach ($settings as $setting) {
                if($setting['type'] == 'integer') {
                    $cacheContent .= "\ndefine('SETTINGS_". strtoupper($setting['setting']) ."', {$this->post[$setting['setting']]});";

                } else if($setting['type'] == 'boolean') {
                    $cacheContent .= "\ndefine('SETTINGS_". strtoupper($setting['setting']) ."', ". (($this->post[$setting['setting']] == 1) ? 'true' : 'false') .");";

                } else if($setting['type'] == 'checkbox') {
                    $cacheContent .= "\ndefine('SETTINGS_". strtoupper($setting['setting']) ."', '". str_replace("'", "\'", json_encode($this->post[$setting['setting']])) ."');";

                } else {
                    $cacheContent .= "\ndefine('SETTINGS_". strtoupper($setting['setting']) ."', '". str_replace("'", "\'", $this->post[$setting['setting']]) ."');";
                }

                // Daca valoarea setarii este diferita de cea din baza de date
                if( key_exists($setting['setting'], $this->post) AND $setting['value'] != $this->post[$setting['setting']] ) {

                    switch ($setting['type']) {

                        // Integer
                        case 'integer':
                            Validate::integer($this->post[$setting['setting']], sprintf('Setarea %1$s trebuie sa fie numar intreg pozitiv.', "<b>{$setting['titlu']}</b>"), 1);
                            break;

                        // Float
                        case 'float':
                            Validate::flaot($this->post[$setting['setting']], sprintf('Setarea %1$s trebuie sa fie numar float (cu punct) pozitiv.', "<b>{$setting['titlu']}</b>"), 1);
                            break;

                        // Multi-checkbox
                        case 'checkbox':
                            $this->post[$setting['setting']] = json_encode($this->post[$setting['setting']]);
                            break;
                    }

                    if(Uim::countErors() == $errors) {
                        $SettingsModel->save(array('id' => $setting['id'], 'value' => $this->post[$setting['setting']]));
                        ++$success;
                    } else {
                        $errors += Uim::countErors();
                    }
                }
            }

            // Salveaza setarile in cache
            file_put_contents(ROOT .'/cache/settings.php', $cacheContent);

            if($success > 0) {
                if($success == 1) {
                    Uim::addMessage('O setare a fost modificatea.');
                } else {
                    Uim::addMessage(sprintf('Un numar de %1$s setari au fost modificate.', $success));
                }

                //LoguriLoguriModel::add(LoguriLoguriModel::ACTIUNE_UPDATE, 'A modificat una sau mai multe setari.');

            } else if($success == 0 AND $errors == 0) {
                Uim::addWarning('Nici o setare nu a fost modificata.');
            }
        }

        ########################################################################################################################################################
        ########################################################################################################################################################

        // Get all settings categories
        $settingsCategories = $SettingsCategoriesModel->getBy();

        $settings = array();
        foreach ($settingsCategories as $key => $category) {
            $settings[$category['name']] = $SettingsModel->getBy(array(), array('category_id' => $category['id'], 'account_id' => 'IS NULL'), array(), array(), null, false);
        }

        // Remove empty categories
        $settings = array_filter(array_map('array_filter', $settings));

        $this->render->setData('template', $template);
        $this->render->setData('settings', $settings);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Settings/views/settings.html.php'));
        $this->render->renderPage('private.html.php'); return true;
    }

    /**
     * Application checkpoints
     */
    public function checkpoints()
    {
        $template = array(
            'title'         => 'Setari',
            'activeMenu'    => 'checkpoints',
            'method'        => \SportArea\Core\Utils::camelCaseToLowerCase(__FUNCTION__)
        );

        $Model = new \SportArea\Core\Model();
		$mysqlTime	= $Model->query('SELECT NOW() AS `time`');

        require_once ROOT.'/config.requirements.php';

        $this->render->setData('times', array('php' => date('Y-m-d H:i:s'), 'mysql' => $mysqlTime[0]['time']));
        $this->render->setData('checkpoints', $_requirements);
        $this->render->setData('template', $template);
        $this->render->addBuffer($this->render->renderView(ROOT . '/Application/Settings/views/checkpoints.html.php'));
        $this->render->renderPage('private.html.php'); return true;
    }
}