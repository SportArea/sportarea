<?php

namespace Application\Settings;

// CORE
use \SportArea\Core\Validate as Validate;
use \SportArea\Core\Model as Model;

class SettingsModel extends Model
{
    protected $table = 'settings';

    public function table() {
        return array(
        );
    }

    /**
     * Get one setting value by key
     *
     * @param   string  $settingKey
     * @return  string/boolean
     */
    public static function get($settingKey, $accountID = null) {
        $SettingsModel = new SettingsModel();
        
        if($accountID == null) {
            $settings = $SettingsModel->getBy(array(), array('setting' => $settingKey));
        } else {
            $settings = $SettingsModel->getBy(array(), array('setting' => $settingKey, 'account_id' => $accountID));
        }

        if(Validate::isArray($settings, null, 1)) {
            return $settings['0']['value'];
        } else {
            return false;
        }
    }
}