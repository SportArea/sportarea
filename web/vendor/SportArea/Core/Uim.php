<?php

namespace SportArea\Core;

/**
 * Errors, Warnings and Messages class
 */
class Uim {

	// Set a error message into session
	public static function addError($error) {
		if (!empty($error)) {
			$_SESSION['uim_errors'][] = $error;
		}
	}

	// Set a error message into session
	public static function addErrorAndRedirect($error, $redirectURL) {
		if (!empty($error)) {
			$_SESSION['uim_errors'][] = $error;
		}

        $Response = new Response();
        $Response->redirect($redirectURL);
	}

	// Set a error message into session
	public static function getErrors() {
		return isset($_SESSION['uim_errors']) ? $_SESSION['uim_errors'] : array();
	}

	// Set a successfully message into session
	public static function addMessage($message) {
		if (!empty($message)) {
			$_SESSION['uim_messages'][] = $message;
		}
	}

	// Set a successfully message into session
	public static function addWarning($warning) {
		if (!empty($warning)) {
			$_SESSION['uim_warnings'][] = $warning;
		}
	}

	// Check if we have errors messages into session
	public static function haveErrors() {
		if (isset($_SESSION['uim_errors']) AND is_array($_SESSION['uim_errors']) AND count($_SESSION['uim_errors']) >= 1) {
			return true;
		} else {
			return false;
		}
	}

	// Check if we have errors messages into session
	public static function haveMessages() {
		if (isset($_SESSION['uim_messages']) AND is_array($_SESSION['uim_messages']) AND count($_SESSION['uim_messages']) >= 1) {
			return true;
		} else {
			return false;
		}
	}

	// Check if we have errors messages into session
	public static function haveWarnings() {
		if (isset($_SESSION['uim_warnings']) AND is_array($_SESSION['uim_warnings']) AND count($_SESSION['uim_warnings']) >= 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Count how many errors and messages we have here
	 *
	 * @return	integer
	 */
	public static function countLogs() {

		$errors		= 0;
		$messages	= 0;
		$warnings	= 0;

		if (isset($_SESSION['uim_errors']) AND is_array($_SESSION['uim_errors'])) {
			$errors = count($_SESSION['uim_errors']);
		}

		if (isset($_SESSION['uim_messages']) AND is_array($_SESSION['uim_messages'])) {
			$messages = count($_SESSION['uim_messages']);
		}

		if (isset($_SESSION['uim_warnings']) AND is_array($_SESSION['uim_warnings'])) {
			$warnings = count($_SESSION['uim_warnings']);
		}

		return ($errors + $messages + $warnings);
	}

	public static function countErors() {
		$errors = 0;

		if (isset($_SESSION['uim_errors']) AND is_array($_SESSION['uim_errors'])) {
			$errors = count($_SESSION['uim_errors']);
		}

		return ($errors);
	}

	public static function clear() {
        if(isset($_SESSION)) {
            unset($_SESSION['uim_errors'], $_SESSION['uim_messages'], $_SESSION['uim_warnings']);
        }
	}

	/**
	 * Print all errors and successfully messages, and remove they from session
	 */
	public static function showErrorAndMessagesLogs() {

		//echo '<div class="errors-and-messages">';

		if ( isset($_SESSION['uim_errors']) OR isset($_SESSION['uim_messages']) OR isset($_SESSION['uim_warnings']) ) {

			if (isset($_SESSION['uim_errors'])) {
				if (is_array($_SESSION['uim_errors'])) {

					// Remove duplicate values
					$_SESSION['uim_errors'] = array_unique($_SESSION['uim_errors']);

					echo '<div class="alert alert-danger">';
					foreach ($_SESSION['uim_errors'] as $key => $error) {
						echo "<p>{$error}</p>";
					}
					echo '</div>';
					unset($_SESSION['uim_errors']);
				}
			}

			if (isset($_SESSION['uim_messages'])) {
				if (is_array($_SESSION['uim_messages'])) {

					// Remove duplicate values
					$_SESSION['uim_messages'] = array_unique($_SESSION['uim_messages']);

					echo '<div class="alert alert-success">';
					foreach ($_SESSION['uim_messages'] as $key => $message) {
						echo "<p>{$message}</p>";
					}
					echo '</div>';
					unset($_SESSION['uim_messages']);
				}
			}

			if (isset($_SESSION['uim_warnings'])) {
				if (is_array($_SESSION['uim_warnings'])) {

					// Remove duplicate values
					$_SESSION['uim_warnings'] = array_unique($_SESSION['uim_warnings']);

					echo '<div class="alert alert-warning">';
					foreach ($_SESSION['uim_warnings'] as $key => $message) {
						echo "<p>{$message}</p>";
					}
					echo '</div>';
					unset($_SESSION['uim_warnings']);
				}
			}

			//echo '</div><div style="clear:both;">';
		}

		//echo '</div>';
	}

	/**
     * Returns all errors and successfully messages, and remove they from session
     */
    public static function getErrorLogs()
    {

        $html = '';

        if( isset($_SESSION['uim_errors']) OR isset($_SESSION['uim_messages']) OR isset($_SESSION['uim_warnings']) ) {

            if( isset($_SESSION['uim_errors']) ) {
                if( is_array($_SESSION['uim_errors']) ) {

                    // Remove duplicate values
                    $_SESSION['uim_errors'] = array_unique($_SESSION['uim_errors']);

                    foreach( $_SESSION['uim_errors'] as $key => $error )
                    {
                        $html .= "{$error}";
                    }
                    unset($_SESSION['uim_errors']);
                }
            }

            if( isset($_SESSION['uim_warnings']) ) {
                if( is_array($_SESSION['uim_warnings']) ) {

                    // Remove duplicate values
                    $_SESSION['uim_warnings'] = array_unique($_SESSION['uim_warnings']);

                    foreach( $_SESSION['uim_warnings'] as $key => $message )
                    {
                        $html .= "{$message}";
                    }
                    unset($_SESSION['uim_warnings']);
                }
            }
        }

        return $html;
    }
}