<?php

/**
 * Routes key represents the URI request
 * Routes values represents the controller/action
 *
 * Also, see the https://ellislab.com/codeigniter/user-guide/general/routing.html
 * (:any)
 * (:num)
 *
 * @author  Norbert Hegedus <hegedus.norbert@yahoo.ro>
 */

$routes                     =   array();

$routes = array();

$routes['admin']        = 'AdminAuthentication/login';
$routes['admin/login']  = 'AdminAuthentication/login';
$routes['admin/logout'] = 'AdminAuthentication/logout';
