<?php

namespace SportArea\Core;

// Core
use SportArea\Core\Controller;

class Access extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if(!isset($this->module)) {
            // TODO: cach error, controller without module defined
            Uim::addWarning('Controllerul <b>\\'. get_called_class() .'</b> nu are definita tabela (<i>protected $module = \'\'</i>) de care aparține, putand fi accesat de orice utilizator si fara drepturi.');
        }

        if(!Validate::isArray($this->loggedUser, null, 1)) {
            // TODO: cache error, redirect to dashboad or to login page
            Uim::addError('Nu ești autentificat.');
            $this->response->redirect(BASE_URL);

        } else if(Validate::isArray($this->loggedUser['modules'], null, 0) && isset($this->module) && !in_array($this->module, $this->loggedUser['modules']) ) {
            //die('Nu ai drepturi pe această pagina.');
        }
    }

}