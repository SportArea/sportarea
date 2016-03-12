<?php

namespace SportArea\Core;

use SportArea\Core\Session as Session;


class Flash
{

    private $session;
    private $sessionName = 'flashMessages';

    public function __construct()
    {
        $this->session = new Session();
        $this->session->start();
    }

    /**
     * Success messages
     *
     * @param   string  $string
     */
    public function success($string)
    {
        // TODO: use session class
        $_SESSION[$this->sessionName][__FUNCTION__][] = $string;
    }

    /**
     * Errors messages
     *
     * @param   string  $string
     */
    public function error($string)
    {
        // TODO: use session class
        $_SESSION[$this->sessionName][__FUNCTION__][] = $string;
    }

    /**
     * Notices messages
     *
     * @param   string  $string
     */
    public function notice($string)
    {
        // TODO: use session class
        $_SESSION[$this->sessionName][__FUNCTION__][] = $string;
    }

    /**
     * Destroy all the flash messages
     *
     */
    public function destroy()
    {
        $this->session->delete($this->sessionName);
    }

}
