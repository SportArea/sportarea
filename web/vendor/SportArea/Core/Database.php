<?php

namespace SportArea\Core;

class Database
{

	// object instance
	private static $_instance = null;
	// DB connection variables
	private $_dbHost = null;
	private $_dbName = null;
	private $_dbUser = null;
	private $_dbPass = null;
	private $_dbDriver = null;
	// PDO object
	private $_pdo = null;
	// last executed PDO statement
	private $_lastStmt = null;

	/**
	 * Class constructor
	 *
	 * It has to be declared private to forbid direct calling
	 *
	 * @access private
	 */
	public function __construct() {
		// config parameters check
		$this->_checkConfig();
	}

	/**
	 * Returns an instance of the object
	 *
	 * @return object
	 */
	public static function getInstance() {
		if (self::$_instance === null) {
			// pregatim instanta daca nu o avem setata
			self::$_instance = new Database();
		}

		return self::$_instance;
	}

	/**
	 * Checks if the config data are set
	 *
	 * It doesn't stop execution, it only shows the config
	 *
	 * @access private
	 */
	private function _checkConfig() {
		// trying to read the configuration
		if (( $this->_dbHost = DB_HOST ) === false) {
			printf("%s: config: missing %s\n", __CLASS__, 'database_host');
		}

		if (( $this->_dbUser = DB_USERNAME ) === false) {
			printf("%s: config: missing %s\n", __CLASS__, 'database_user');
		}

		if (( $this->_dbPass = DB_PASSWORD ) === false) {
			printf("%s: config: missing %s\n", __CLASS__, 'database_password');
		}

		if (( $this->_dbName = DB_NAME ) === false) {
			printf("%s: config: missing %s\n", __CLASS__, 'database_name');
		}

		if (( $this->_dbDriver = DB_DRIVER ) == false) {
			printf("%s: config: missing %s\n", __CLASS__, 'database_driver');
		}
	}

	/**
	 * Connects to the database
	 *
	 * @parameter bool $throwExceptions
	 */
	public function connect($username = null, $password = '', $throwExceptions = false) {
		if (( $this->_pdo === null ) || ( $username !== null )) {
			// if we have a username and password specified
			if ($username !== null) {
				$this->_dbUser = $username;
				$this->_dbPass = $password;
			}

			switch ($this->_dbDriver) {
				case 'sqlsrv': $dsn = sprintf("%s:Server=%s;Database=%s", $this->_dbDriver, $this->_dbHost, $this->_dbName);
					break;
				case 'odbc': $dsn = sprintf("%s:%s", $this->_dbDriver, $this->_dbName);
					break;
				default: $dsn = sprintf("%s:host=%s;dbname=%s", $this->_dbDriver, $this->_dbHost, $this->_dbName);
			}

			try {
				$this->_pdo = new \PDO($dsn, $this->_dbUser, $this->_dbPass);
				$this->_pdo->exec("SET NAMES UTF8");

			} catch (Exception $e) {
				if ($throwExceptions) {
					throw $e;
				} else {
					// this is a fatal error, we can't work without a database
					// throw new Exception('Could not connect to the database: ' . $e->getMessage());
					die('Could not connect to the database: ' . $e->getMessage());
				}
			}

			// Return errors
			$this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
	}

	/**
	 * Escapes and prepares the data for sql
	 *
	 * @param string $value
	 * @param string $type - text/numeric
	 * @return string
	 */
	public function quote($value = "", $type = "") {
		// if the value is NULL we don't care about the type, we return NULL
		if ($value === null) {
			return 'NULL';
		}

		// if the value is boolean, we convert it to a number
		if (is_bool($value)) {
			$value = ($value === true) ? 1 : 0;
		}

		switch (strtolower($type)) {
			case 'number':
			case 'numeric':
				if (is_numeric($value))
					return $value;
				else
					return 0;

				break;

			case 'text':
				// inlocuim caracterul NUL si ghilimelele simple (separator de parametru in SQL)
				return "'" . str_replace(array("\0", "'"), array("", "''"), $value) . "'";

				break;

			default:
				return $this->quote($value, (is_numeric($value)) ? "Number" : "Text");

				break;
		}
	}

	/**
	 * Executes a SQL query (wrapper)
	 *
	 * In case of an error, the execution is stopped
	 *
	 * @param string $sql - PDO prepare kind of SQL (bind parameters :name)
	 * @param array $parameters - bind parameters ( ':name' => 'test' )
	 * @param bool $ignore_errors
	 * @return statement|bool
	 * @throws Exception
	 */
	public function query($sql = "", $parameters = array(), $ignore_errors = false) {

		// get the query method which will be accessed
		if (method_exists($this, 'query_' . $this->_dbDriver)) {
			$method = 'query_' . $this->_dbDriver;
		} else {
			$method = 'query_default';
		}

		// execute the method
		try {
			$stmt = $this->$method($sql, $parameters, $ignore_errors);

			// Development only
			/*
			if(SetariSetariModel::get('environment') == 'development') {
				// Trateaza erorile de tip warning
				$warnings = $this->$method('SHOW WARNINGS')->fetchAll();
				if(Validate::isArray($warnings, null, 1)) {
					foreach ($warnings as $warning) {
						Exceptionhandler::myErrorHandler(0, $warning['Message'].'<hr />'. $sql, __FILE__, __LINE__, null, false);
					}
				}
			}
			 */

		} catch (Exceptionhandler $e) {
			// in case of errors we throw an exception if we don't ignore errors
			if (!$ignore_errors) {
				throw new Exceptionhandler($e->getMessage());
			} else {
				return false;
			}
		}

		return $stmt;
	}

	/**
	 * Executes a SQL query on the ODBC database
	 *
	 * In case of an error, the execution is stopped
	 *
	 * @param string $sql - PDO prepare kind of SQL (bind parameters :name)
	 * @param array $parameters - bind parameters ( ':name' => 'test' )
	 * @param bool $ignore_errors
	 * @return statement|bool
	 * @throws Exception
	 */
	public function query_odbc($sql = "", $parameters = array(), $ignore_errors = false) {
		// connecting to db
		$this->connect();

		// seems that ODBC doesn't support multiple concurrent statements. we have to close the previous one if it's stil active
		if ($this->_lastStmt) {
			$this->_lastStmt->closeCursor();
		}

		// reset the last statement
		$this->_lastStmt = null;

		// quote all parameters
		foreach ($parameters as $key => $value) {
			$parameters[$key] = $this->quote($value);
		}

		// we convert the SQL from bind parameters format to simple format
		$sql = str_replace(array_keys($parameters), array_values($parameters), $sql);

		// execute the statement
		try {
			$stmt = $this->_pdo->query($sql);

		} catch (Exception $e) {
			// in case of errors we throw an exception if we don't ignore errors
			if (!$ignore_errors) {
				throw new Exception($e->getMessage());
			} else {
				return false;
			}
		}

		$this->_lastStmt = $stmt;

		return $stmt;
	}

	/**
	 * Executes a SQL query on the "default" database
	 *
	 * In case of an error, the execution is stopped
	 *
	 * @param string $sql - PDO prepare kind of SQL (bind parameters :name)
	 * @param array $parameters - bind parameters ( ':name' => 'test' )
	 * @param bool $ignore_errors
	 * @return statement|bool
	 * @throws Exception
	 */
	public function query_default($sql = '', $parameters = array(), $ignore_errors = false) {

		// connecting to db
		$this->connect();

		// reset the last statement
		$this->_lastStmt = null;

		// prepare the statement
		try {
			$stmt = $this->_pdo->prepare($sql);

		} catch (Exception $e) {
			// in case of errors we throw an exception if we don't ignore errors
			if (!$ignore_errors) {
				throw new Exception($e->getMessage());
			} else {
				return false;
			}
		}

        //print_r($parameters);die;

        // Null values
        if(is_array($parameters) AND count($parameters) > 0) {
            foreach ($parameters as $parameter => $value) {
                $value = trim($value);

                if(empty($value) || $value == null || $value == ':NULL') {
                    $stmt->bindValue($parameter, null, \PDO::PARAM_NULL);
                }
            }
        }

		// execute the statement
		if (!$stmt->execute($parameters)) {
        //if (!$stmt->execute()) {

			// in case of errors we throw an exception if we don't ignore errors
			if (!$ignore_errors) {
				// errorInfo will contain:
				// [0] - error code
				// [1] - driver specific error code
				// [2] - driver specific error message
				$errorInfo = $stmt->errorInfo();
				throw new Exception(sprintf("%s: %s", $errorInfo[1], $errorInfo[2]));
			} else {
				return false;
			}
		}

		$this->_lastStmt = $stmt;

		return $stmt;
	}

	/**
	 * Returns a row from the result (associative)
	 * @param statement $stmt
	 * @return array|boolean
	 */
	public function fetchAssoc($stmt = null) {
		// if we don't have a statement, and we don't have a last statement, we return false
		$stmt = ( $stmt ) ? $stmt : $this->_lastStmt;
		if (!$stmt) {
			return false;
        }

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Return a row from the result (object)
	 * @param statement $stmt
	 * @return object|false
	 */
	public function fetchObject($stmt = null) {
		// if we don't have a statement, and we don't have a last statement, we return false
		$stmt = ( $stmt ) ? $stmt : $this->_lastStmt;
		if (!$stmt) {
			return false;
        }

		// cannot use fetchObject because with ODBC we get the error: Fatal error: Cannot access empty property
		$return = $this->fetchAssoc($stmt);
		return ( $return !== false ) ? (object) $return : false;
	}

	/**
	 * Returns all the rows from the result (associative)
	 * @param statement $stmt
	 * @return array|boolean
	 */
	public function fetchAll($stmt = null) {
		// if we don't have a statement, and we don't have a last statement, we return false
		$stmt = ( $stmt ) ? $stmt : $this->_lastStmt;
		if (!$stmt) {
			return false;
        }

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	/**
	 * returns the last inserted ID in the database
	 * @return int
	 */
	public function lastInsertId() {
		$sql = "SELECT @@IDENTITY AS lastId";
		$res = $this->query($sql);

		$row = $this->fetchAssoc($res);

		return $row['lastId'];
	}

}