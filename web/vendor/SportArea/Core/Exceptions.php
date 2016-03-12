<?php

namespace SportArea\Core;

use Application\Errors\ErrorsModel;
use Application\Settings\SettingsModel;

class Exceptions extends \Exception
{

	/**
	 * @param	integer	$errno
	 * @param	string	$errstr
	 * @param	string	$errfile
	 * @param	integer	$errline
	 * @param	object	$object
	 * @param	boolean	$returnErrorMessage
	 * @return	void
	 *
	 */
	static public function errorHandler($errno, $errstr, $errfile, $errline, $object = null, $returnErrorMessage = true) {

		$Session		= new Session();
		$User			= unserialize($Session->get('user'));

		// Do no track MDFP errors
		if(preg_match('/MPDF57/i', $errfile)) {
			return;
		}

		$requestPage = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

		if (!preg_match('/(http:\/\/htpps:\/\/)/', $requestPage)) {
			$requestPage = 'http://' . $requestPage;
		}

		$phpErrors = array(
			0 => 'TRIGGERED',
			1 => 'E_ERROR',
			2 => 'E_WARNING',
			4 => 'E_PARSE',
			8 => 'E_NOTICE',
			16 => 'E_CORE_ERROR',
			32 => 'E_CORE_WARNING',
			64 => 'E_COMPILE_ERROR',
			128 => 'E_COMPILE_WARNING',
			256 => 'E_USER_ERROR',
			512 => 'E_USER_WARNING',
			1024 => 'E_USER_NOTICE',
			2048 => 'E_STRICT',
			4096 => 'E_RECOVERABLE_ERROR',
			8192 => 'E_DEPRECATED',
			32767 => 'E_ALL',
			16384 => 'E_USER_DEPRECATED',
			42000 => 'SQLSTATE',
			01000 => 'SQLSTATE',
			'42S02'	=> 'SQLSTATE',
			'42S22'	=> 'SQLSTATE',
			'HY000'	=> 'SQLSTATE'
		);

		$Erori = new ErrorsModel();
		$params = array(
			'number'			=> $errno,
			'error'				=> html_entity_decode($errstr),
			'type'				=> (isset($phpErrors[$errno]) ? $phpErrors[$errno] : 0),
			'file'				=> $errfile,
			'line'				=> $errline,
			'first_seen'		=> date('Y-m-d H:i:s'),
			'last_seen'			=> date('Y-m-d H:i:s'),
			'hits'				=> 1,
			'ip'				=> Utils::getRealIp(),
			'user_id'			=> ($User['id'] ? $User['id'] : null),
			//'cont_emitere_uid'	=> (isset($_REQUEST['apiKey']) ? $_REQUEST['apiKey'] : null),
			'request'			=> $requestPage,
			'token'				=> md5($errno . html_entity_decode($errstr) . $errfile . $errline . $requestPage)
		);


		if(is_object($object)) {
            $objectTrace = $object->getTrace();

            if(isset($objectTrace[1]['args'][0])) {

                $params['error'] .= "<br /><hr style=\"margin: 5px 0;\"/>". $objectTrace[1]['args'][0];

                if(is_array($objectTrace[1]['args'][1]) AND count($objectTrace[1]['args'][1]) > 0) {
                    $params['error'] .= "<br /><hr style=\"margin: 5px 0;\"/>";
                    $i = 0;
                    foreach ($objectTrace[1]['args'][1] as $paramKey => $paramValue) {
                        ($i > 0) ? $params['error'] .= '<br />' : null;
                        $params['error'] .= $paramKey .' = '. $paramValue;
                        ++$i;
                    }
                }
            }
		}

		$eroare = $Erori->getBy(array(), array('token' => $params['token']));

		if(Validate::isArray($eroare, null, 1)) {
			$Erori->save(array('id' => $eroare[0]['id'], 'hits' => ++$eroare[0]['hits'], 'last_seen' => date('Y-m-d H:i:s')));
		} else {
			$Erori->save($params);
		}

		if(SettingsModel::get('environment') == 'production') {
			// If the number of errors in the last X minites are > than Y
//			$errors = $Erori->countErrorsInTime(60);
//			if($errors > 3) {
//				$Email = new Email();
//				$Email->send('hegedus.norbert@yahoo.ro', '[ERRORS]', "A number of {$errors} occurred in the last 60 minutes.");
//			}
		}

		/**
		 * Pe instanta production nu se afiseaza deloc eroare, in cazul in care această e de tip E_NOTICE (insa se inregistreaza in DB)
		 */
		if( (SettingsModel::get('environment') == 'development' AND $returnErrorMessage == true)
				OR (SettingsModel::get('environment') != 'development' AND $returnErrorMessage == true AND $params['type'] != 'E_NOTICE') ) {
			// If notice
			if($errno != 0) {

				// Show the errors only on the DEV instance
				if(SettingsModel::get('environment') == 'development') {
					Uim::addError($errstr .' in '. $errfile .' on line '. $errline);
				} else {
					Uim::addError('A avut loc o eroare internă. Vă rugăm să contactați imediat echipa tehnică pentru rezolvarea ei.');
				}

			// If another error type
			} else {

				// Show the errors only on the DEV instance
				if(SettingsModel::get('environment') == 'development') {
					Uim::addError($errstr .' in '. $errfile .' on line '. $errline);
				} else {
					Uim::addError('A avut loc o eroare internă. Vă rugăm să contactați imediat echipa tehnică pentru rezolvarea ei.');
				}
/*
				$Render = new Render();
				$Render->setData('template', array('title' => 'Eroare internă'));
				$Render->renderPage(false, 'template.html.php');
 */
				return;
			}
		}
		return;
	}


	static public function shutDownFunction() {
		$error = error_get_last();
		if ($error['type'] == 1) {
			self::errorHandler(E_USER_ERROR, $error['message'], $error['file'], $error['line']);
		}
	}
}