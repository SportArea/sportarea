<?php

namespace SportArea\Core;

class Core
{
    protected $session;
    protected $cookie;
    protected $render;
    protected $flash;
    protected $post;
    protected $get;
    protected $request;
    protected $files;
    protected $response;

    public $loggedUser = array();

    public function __construct()
    {

        $this->session  =   new Session();
        $this->cookie   =   new Cookie();
        $this->render   =   new Render();
        $this->flash    =   new Flash();
        $this->response =   new Response();

        // Start the session
        $this->session->start();

        /**
         * TODO: validate and sanitize
         */
        $this->post     = (isset($_POST) ? $_POST : null);
        unset($_POST);

        /**
         * TODO: validate and sanitize
         */
        $this->get      = (isset($_GET) ? $_GET : null);
        unset($_GET);

        /**
         * TODO: validate and sanitize
         */
        $this->request  = (isset($_REQUEST) ? $_REQUEST : null);
        unset($_REQUEST);

        /**
         * TODO: validate and sanitize
         */
        $this->files      = (isset($_FILES) ? $_FILES : null);
        unset($_FILES);

        $this->loggedUser = $this->session->get('loggedUser');
    }
}