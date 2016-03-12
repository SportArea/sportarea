<?php

namespace SportArea\Core;

/**
 * Session handling class
 */
class Session
{

    /**
     * Start the session
     */
    public function start()
    {
        if (!isset($_SESSION)) {
            @session_start();
        }
    }

    /**
     * Regenerates the session id (create a new session with a new id and containing the data from the old session), also, delete the old session
     * Call this method whenever you do a privilege change in order to prevent session hijacking.
     */
    public function regenerateID() {
        session_regenerate_id(true);
    }

    /**
     * Stops the session
     */
    public function stop()
    {
        if (isset($_SESSION)) {
            session_write_close();
        }
    }

    /**
     * Returns a value from an array, or false if the key is not defined
     *
     * @param array $array
     * @param string $key
     * @return mixed
     * @access private
     */
    private function _getFromArray(&$array, $key = '')
    {
        if (!isset($array[$key])) {
            return false;
        }

        return $array[$key];
    }

    /**
     * Returns a session value
     *
     * @param	string $key
     * @return	string
     */
    public function get($key = '')
    {
        // start the session if it's not already started
        $this->start();

        if(!empty($key)) {
            return $this->_getFromArray($_SESSION, $key);
        } else {
            return $_SESSION;
        }
    }

    public function sett() {
        $data = func_get_args();

        if(count($data) < 2){
            // handle exception
        }

        $val = array_shift($data);

        $value = &$_SESSION[array_shift($data)];

        foreach($data as $key){
            if(!isset($value[$key])){
                $value[$key] = array();
            }

            $value = &$value[$key];
        }

        $value = $val;
    }

    /**
     * Sets a session value
     *
     * @param   mixed   $mixed
     * @param   mixed   $value
     */
    public function set($mixed, $value = '')
    {
        // start the session if it's not already started
        $this->start();

        if(is_array($mixed)) {
            array_push($_SESSION, $mixed);
        } else {
            $_SESSION[$mixed] = $value;
        }
    }

    /**
     * Deletes a key from the session
     *
     * @param string $key
     */
    public function delete($key)
    {
        // start the session if it's not already started
        $this->start();

        if (isset($_SESSION[$key])) {
            $_SESSION[$key] = null;
            unset($_SESSION[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the current Session ID
     *
     * @return string
     */
    public function getSessionId()
    {
        return session_id();
    }

    /**
     * Destroys a session
     */
    public function destroy()
    {
        $this->start();

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }

        // Destroy the session
        @session_destroy();
    }
}