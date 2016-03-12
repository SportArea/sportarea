<?php

namespace SportArea\Core;

class Validate extends Core
{
    const V_REQUIRED            =   'Ensure the value is requried and not empty';
    const V_REGEXP              =   'REGEXP';
    const V_BOOLEAN             =   'Boolean';

    const V_MIN_VALUE           =   'Recommended for numbers, dates';
    const V_MAX_VALUE           =   'Recommended for numbers, dates';
    const V_MIN_LENGTH          =   'Recommended for string. This method use strlen() to validate the input';
    const V_MAX_LENGTH          =   'Recommended for string. This method use strlen() to validate the input';

    // Alpha
    const V_ALPHA               =   'Ensure only alpha characters are present in the key value (a-z, A-Z)';
    const V_ALPHA_SPACE         =   'Ensure only space and alpha characters are present in the key value (a-z, A-Z)';
    const V_ALPHA_NUM           =   'Ensure only alpha-numeric characters are present in the key value (a-z, A-Z, 0-9)';
    const V_ALPHA_NUM_SPACE     =   'Ensure only space and alpha-numeric characters are present in the key value (a-z, A-Z, 0-9)';
    const V_ALPHA_DASH          =   'Ensure only alpha-numeric characters + dashes and underscores are present in the key value (a-z, A-Z, 0-9, _-)';

    // Numbers/Math
    const V_NUMERIC             =   'Ensure only numeric key values: -21, -11.31, 0, 31, 121, 152.30';
    const V_NUMERIC_UNSIGNED    =   'Ensure only numeric key values: 0, 31, 121, 152.30';
    const V_INTEGER             =   'Ensure only integer key values: -21, 0, 31, 121';
    const V_INTEGER_UNSIGNED    =   'Ensure only unsigned integer key values: 0, 31, 121';
    const V_FLOAT               =   'Ensure only float key values';
    const V_FLOAT_UNSIGNED      =   'Ensure only float key values';

    // Strings
    const V_EMAIL               =   'Checks for a valid email address';
    const V_IBAN                =   'Check for a valid IBAN';
    const V_CC                  =   'Check for a valid credit card number (Uses the MOD10 Checksum Algorithm)';

    // Date
    const V_DATE                =   'Determine if the provided input is a valid date (ISO 8601 / YYYY-MM-DD)';
    const V_TIME                =   'V_TIME';
    const V_DATE_TIME           =   'V_DATE_TIME';

    // Network
    const V_IPV4                =   'Check for valid IPv4 address';
    const V_IPV4_WILDCARD       =   'Check for valid IPv4 address but with wildcard/s';
    const V_IPV6                =   'Check for valid IPv6 address';

    // Other
    const V_RO_CUI              =   'V_RO_CUI';
    const V_RO_CNP              =   'V_RO_CNP';
    const V_RO_CNP_OR_CUI       =   'V_RO_CNP_OR_CUI';

    private static $lang = 'RO-RO';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Validat params by model table definition
     *
     * @param   array   $params
     * @param   array   $tableDefinition
     * @return  boolean
     */
    public static function model($params, $tableDefinition, $tableName)
    {

        $errors = array();

        // Search by table definision
        foreach ($tableDefinition as $columnName => $definitions) {

            // Check for required column
            if(
                    isset($definitions['rules'])
                    &&
                    (
                        // Required, and NOT boolean type
                        (
                            in_array(self::V_REQUIRED, $definitions['rules'])
                            && !in_array(self::V_BOOLEAN, $definitions['rules'])
                            && ( !isset($params[$columnName]) || (isset($params[$columnName]) && empty($params[$columnName])) )
                        )
                        ||
                        // Required, and boolean type
                        (
                            in_array(self::V_REQUIRED, $definitions['rules'])
                            && in_array(self::V_BOOLEAN, $definitions['rules'])
                            && ( !isset($params[$columnName]) || (isset($params[$columnName]) && !is_bool($params[$columnName])) )
                        )
                    )
                ) {

                // TODO: thrown exception

                if(\Application\Settings\SettingsModel::get('environment') == 'development') {
                    $errors[] = sprintf('Campul <b>%s (%s.%s)</b> este obligatoriu.', $definitions['i18n'][self::$lang], $tableName, $columnName);
                } else {
                    $errors[] = sprintf('Campul %s este obligatoriu.', $definitions['i18n'][self::$lang]);
                }
            }

            // Object / Constraint
            if(isset($definitions['rules'])) {
                foreach ($definitions['rules'] as $definitionKey => $definitionValue) {
                    if(is_array($definitionValue) && is_object($definitionValue[0]) && isset($params[$columnName])) {
                        $class      = $definitionValue[0];
                        $primary    = $definitionValue[1];
                        if(!Validate::isArray($class->getBy(array(), array($primary => $params[$columnName])), null, 1)) {
                            $errors[] = sprintf('Valoarea campului %s este invalida (nu există in baza de date).', $definitions['i18n'][self::$lang]);
                            // TODO: thrown exception
                        }
                    }
                }
            }
        }

        // Search by params
        foreach ($params as $columnName => $value) {

            // Check if column is defined into definisions
            if(!array_key_exists($columnName, $tableDefinition)) {
                if(\Application\Settings\SettingsModel::get('environment') == 'development') {
                    $errors[] = sprintf('Campul <b>%s</b> nu este definit in metoda <b>%sModel->table()</b>.', $columnName, ucfirst($tableName));
                } else {
                    $errors[] = sprintf('Campul %s nu este definit.', $columnName);
                }

                // TODO: thrown exception
            }

            // V_REGEXP
            if(
                ( isset($tableDefinition[$columnName]) && isset($tableDefinition[$columnName]['rules']) && !empty($value) && array_key_exists(self::V_REGEXP, $tableDefinition[$columnName]['rules']) )
                    ||
                ( isset($tableDefinition[$columnName]) && isset($tableDefinition[$columnName]['rules']) && array_key_exists(self::V_REQUIRED, $tableDefinition[$columnName]['rules']) && array_key_exists(self::V_REGEXP, $tableDefinition[$columnName]['rules']) )
            ) {
                // TODO: thrown exception
                if(!boolval(preg_match($tableDefinition[$columnName]['rules'][self::V_REGEXP], $value))) {
                    $errors[] = sprintf('Valoarea campului %s este incorecta.', $tableDefinition[$columnName]['i18n'][self::$lang]);
                }
            }

        }

        return $errors;
    }

    /**
	 * @param	string $value
	 * @param	string $message
	 * @param	string $regex (regexe)
	 * @return	boolean
	 */
	public static function regex($value, $message = null, $regex) {
		if (!preg_match($regex, $value)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
		return true;
	}

	/**
	 * Validate an integer
	 *
	 * @access	public
	 * @param	integer
	 * @param	integer/null
	 * @param	integer/null
	 * @return	boolean
	 *
	 */
	public static function integer($value, $message = null, $lowerLimit = null, $upperLimit = null) {

		$value = intval($value);

		if ($lowerLimit != null AND $value < $lowerLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($upperLimit != null AND $value > $upperLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate an flaot
	 *
	 * @access	public
	 * @param	integer
	 * @param	integer/null
	 * @param	integer/null
	 * @return	boolean
	 *
	 */
	public static function flaot($value, $message = null, $lowerLimit = null, $upperLimit = null) {

		// Float
		if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($lowerLimit != null AND $value < $lowerLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($upperLimit != null AND $value > $upperLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate a number
	 *
	 * @access	public
	 * @param	integer
	 * @param	integer/null
	 * @param	integer/null
	 * @return	boolean
	 *
	 */
	public static function numeric($value, $message = null, $lowerLimit = null, $upperLimit = null) {

		if (!is_numeric($value)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($lowerLimit != null AND $value < $lowerLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($upperLimit != null AND $value > $upperLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate a php object
	 *
	 * @access	public
	 * @param	object
	 * @param	string
	 * @return	boolean
	 */
	public static function object($object, $message = null) {
		if (!is_object($object)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate a string
	 *
	 * @param	$value string - the string
	 * @param	$lowerLimit integer/null - the lower limit
	 * @param	$upperLimit integer/null - the upper limit
	 * @return	boolean
	 */
	public static function string($value, $message = null, $lowerLimit = null, $upperLimit = null) {

		if (empty($value)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if (!empty($value) AND $lowerLimit != null AND strlen($value) < $lowerLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($upperLimit != null AND strlen($value) > $upperLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate an email address
	 *
	 * @access	public
	 * @param	string
	 * @param	integer/null
	 * @param	integer/null
	 * @return	boolean
	 */
	public static function email($value, $message = null, $lowerLimit = null, $upperLimit = null) {

		if (empty($value)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if (!empty($value) AND !preg_match("/^[+_a-z0-9-]+(\.[+_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $value)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($lowerLimit != null AND strlen($value) < $lowerLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($upperLimit != null AND strlen($value) > $upperLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate if two strings are equal
	 *
	 * @param	string/integer $string1
	 * @param	string/integer $string2
	 * @param	string $message
	 * @param	integer/null $lowerLimit
	 * @param	integer/null $upperLimit
	 * @return	boolean
	 */
	public static function equal($string1, $string2, $message = null, $lowerLimit = null, $upperLimit = null) {

		if ($string1 != $string2) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($lowerLimit != null AND strlen($string1) < $lowerLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($upperLimit != null AND strlen($string1) > $upperLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate a date
	 *
	 * @param	string $date (eg DATE: 2009-09-27)
	 * @param	string $message
	 * @param	string/null $lowerLimit (date should be highter that that limit - eg DATE: 2009-09-27)
	 * @param	string/null $upperLimit (date can't be highter that that limit - eg DATE: 2009-09-27)
	 */
	public static function date($date, $message = null, $lowerLimit = null, $upperLimit = null) {

		if (empty($date)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		list($year, $month, $day) = explode('-', $date);

		if (!$year OR !$month OR !$day) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if (!checkdate($month, $day, $year)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($lowerLimit != null AND strtotime($date) < strtotime($lowerLimit)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if ($upperLimit != null AND strtotime($date) > strtotime($upperLimit)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate an IP
	 *
	 * @param	string $ip
	 * @param	streing $message
	 * @return	boolean
	 */
	public static function IP($ip, $message = false) {
		if (preg_match("^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}^", $ip)) {
			return true;
		} else {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
	}

	public static function IPWildcard($IP, $message = false) {
		$ipMasks = explode('.', $IP);
		foreach ($ipMasks as $mask) {
			if( (is_numeric($mask) AND intval($mask) > 255) OR (!is_numeric($mask) AND $mask !== '*') ) {
				($message != null) ? Uim::addError($message) : null;
				return false;
			}
		}

		return true;
	}

	/**
	 * Validate an array
	 *
	 * @param	array	$array
	 * @param	string $message
	 * @param	integer/null $lowerLimit
	 * @param	integer/null $upperLimit
	 * @return	boolean
	 */
	public static function isArray($array, $message = null, $lowerLimit = null, $upperLimit = null) {

		if (!is_array($array)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if (is_array($array) AND $lowerLimit != null AND count($array) < $lowerLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if (is_array($array) AND $upperLimit != null AND count($array) > $upperLimit) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate an array
	 *
	 * @param	array	$array
	 * @param	string $message
	 * @param	integer/null $lowerLimit
	 * @param	integer/null $upperLimit
	 * @return	boolean
	 */
	public static function inArray($string, $array, $message = null) {

		if (!in_array($string, $array) OR !is_array($array)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		return true;
	}

	/**
	 * Validate an serialized object
	 *
	 * @param	serialized obj	$data
	 * @param	string $message
	 * @return	boolean
	 */
	public static function serialized($data, $message = null) {
		// NEW WAY: RUNNING SLOW IF BIG DATA STRING
		if (preg_match("/(a|O|s|b)\x3a[0-9]*?((\x3a((\x7b?(.+)\x7d)|(\x22(.+)\x22\x3b)))|(\x3b))/", $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Validate if a string is alpha (a-zA-Z)
	 *
	 * @param	string $str
	 * @return	boolean
	 */
	public static function alpha($str, $message = null) {
		if (!preg_match("/^[a-zA-Z]+$/", $str) && $str != '') {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
		return true;
	}


	/**
	 * Validate if a string is alpha numeric (a-zA-Z0-9)
	 *
	 * @param	string $str
	 * @return	boolean
	 */
	public static function alphaNum($str, $message = null) {
		if (!preg_match("/^[a-zA-Z0-9]+$/", $str) && $str != '') {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
		return true;
	}

	/**
	 * Allow: azAZ09 -.
	 *
	 */
	public static function alphaNumSpaceDashDot($str, $message = null) {
		if(!preg_match('/^[a-zA-Z0-9\s-\.]+$/', $str)) {
			(isset($message) AND $message != null) ? Uim::addError($message) : null;
			return false;
		}
		return true;
	}

	/**
	 * Special for Personal Names
	 * Allow: azAZ - (space and - Non Consecutive)
	 *
	 * @param	string $str
	 * @return	boolean
	 */
	public static function alphaNonConsecutiveSpaceDash($str, $message = null) {
		if (!preg_match("/^[A-Za-z]+(?:[\s-][A-Za-z]+)*$/", $str) && $str != '') {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
		return true;
	}

	/**
	 * Special for Personal Names
	 *
	 * @param	string $str
	 * @return	boolean
	 */
	public static function alphaNumNonConsecutiveSpaceDash($str, $message = null) {
		if (!preg_match("/^[A-Za-z0-9]+(?:[\s-][A-Za-z0-9]+)*$/", $str) && $str != '') {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
		return true;
	}

	/**
	 * Validate if a string is alpha + space (azAZ )
	 *
	 * @param	string $str
	 * @return	boolean
	 */
	public static function alphaSpace($str, $message = null) {
		return true;
	}

	/**
	 * Validate if a string is alpha numeric (a-zA-Z0-9-)
	 *
	 * @param	string $str
	 * @return	boolean
	 */
	public static function alphaNumDash($str, $message = null) {
		if (!preg_match("/^[a-zA-Z0-9-]+$/", $str) && $str != '') {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
		return true;
	}

	public static function isUrl($str, $message = null) {
		if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $str)) {
			return true;
		} else {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
	}

	/**
	 * Validate a password, must have:
	 *	Minimum 10 chars
	 *	At least one upper char
	 *  At least one special char
	 *  At least one cipher
	 *
	 * @param type $password
	 * @return boolean
	 */
	public static function password($password, $message = null) {
		if(preg_match('/(?=^.{10,}$)(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*+=]).*$/', $password)) {
			return true;
		}

		($message != null) ? Uim::addError($message) : null;
		return false;
	}

	/**
	 * Validate romanian CIF/CUI
	 *
	 * @param	string	$cif
	 * @param	string	$message
	 * @return	boolean
	 */
	public static function valideazaCIF($cif, $message = null) {
		if (!is_numeric($cif)) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		if (strlen($cif) > 10) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}

		$cifra_control = substr($cif, -1);
		$cif = substr($cif, 0, -1);
		while (strlen($cif) != 9) {
			$cif = '0' . $cif;
		}

		$suma = $cif[0] * 7 + $cif[1] * 5 + $cif[2] * 3 + $cif[3] * 2 + $cif[4] * 1 + $cif[5] * 7 + $cif[6] * 5 + $cif[7] * 3 + $cif[8] * 2;
		$suma = $suma * 10;
		$rest = fmod($suma, 11);
		if ($rest == 10) {
			$rest = 0;
		}

		if ($rest == $cifra_control) {
			return true;

		} else {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
	}

	/**
	 * Validate CNP ( valid for 1800-2099 )
	 *
	 * @param string $cnp
	 * @return boolean
	 */
	public static function valideazaCNP($cnp = null, $message = null) {
		// CNP must have 13 characters
		if(strlen($cnp) != 13) {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
		$cnp = str_split($cnp);
		$hashTable = array( 2 , 7 , 9 , 1 , 4 , 6 , 3 , 5 , 8 , 2 , 7 , 9 );
		$hashResult = 0;
		// All characters must be numeric
		for($i=0 ; $i<13 ; $i++) {
			if(!is_numeric($cnp[$i])) {
				($message != null) ? Uim::addError($message) : null;
				return false;
			}
			$cnp[$i] = (int)$cnp[$i];
			if($i < 12) {
				$hashResult += (int)$cnp[$i] * (int)$hashTable[$i];
			}
		}
		unset($hashTable, $i);
		$hashResult = $hashResult % 11;
		if($hashResult == 10) {
			$hashResult = 1;
		}
		// Check Year
		$year = ($cnp[1] * 10) + $cnp[2];
		switch( $cnp[0] ) {
			case 1  : case 2 : { $year += 1900; } break; // cetateni romani nascuti intre 1 ian 1900 si 31 dec 1999
			case 3  : case 4 : { $year += 1800; } break; // cetateni romani nascuti intre 1 ian 1800 si 31 dec 1899
			case 5  : case 6 : { $year += 2000; } break; // cetateni romani nascuti intre 1 ian 2000 si 31 dec 2099
			case 7  : case 8 : case 9 : {                // rezidenti si Cetateni Straini
				$year += 2000;
				if($year > (int)date('Y')-14) {
					$year -= 100;
				}
			} break;
			default : {
				($message != null) ? Uim::addError($message) : null;
				return false;
			} break;
		}
		$result = ($year > 1800 && $year < 2099 && $cnp[12] == $hashResult);
		if(!$result){
			($message != null) ? Uim::addError($message) : null;
			return  $result;
		}

		return  $result;
	}

	public static function json($string, $message = null) {

		if(is_string($string)) {
			$string = trim($string);

			json_decode($string);

			// That fucking retarded function (json_last_error()) return 0 (means no error) if the parameter is a number. Fucking PHP piece of shit!
			if( (json_last_error() == JSON_ERROR_NONE) AND in_array(substr($string, 0, 1), array('{', '[')) ) {
				return true;
			} else {
				($message != null) ? Uim::addError($message) : null;
				return false;
			}
		} else {
			($message != null) ? Uim::addError($message) : null;
			return false;
		}
	}

}