<?php

namespace SportArea\Core;

use Application\Settings\SettingsModel;

/**
 * Rendering class
 */
class Render
{

    /**
     * render data
     * @access private
     * @var object
     */
    private $data = null;

    /**
     * list of JSs to be included
     * @var array
     */
    private $js = array();

    /**
     * list of inline JSs to be included
     * @var array
     */
    private $inlineJs = array();

    /**
     * list of CSSs to be included
     * @var array
     */
    private $css = array();

    /**
     * content to be displayed
     * @var array
     */
    private $buffer = array();

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        // prepare the rendering data
        $this->clearData();
    }

    /**
     * Prepares the data (empty)
     *
     */
    public function clearData()
    {
       $this->data = new \stdClass();
    }

    /**
     * Sets the render data
     *
     * The $name parameter can be a string or an object storing the data
     *
     * @param string|object $name
     * @param mixed $value
     * @return boolean
     */
    public function setData($name = '', $value = null)
    {
        if (is_object($name)) {
            // if name is an object we set the data from this object
            foreach (get_object_vars($name) as $key => $val) {
                $this->data->$key = $val;
            }
        } elseif (is_array($name)) {
            // if name is an array we set the data from this array
            foreach (array_keys($name) as $key => $val) {
                $this->data->$key = $val;
            }
        } elseif (is_string($name)) {
            // if the name is a string
            $this->data->$name = $value;
        } else {
            // if the first parameter is not an object or a string, we don't do anything
            return false;
        }

        return true;
    }

    /**
     * Clears the output buffer
     *
     */
    public function clearBuffer()
    {
        $this->buffer = array();
    }

    /**
     * Adds content to the output buffer (used by renderPage)
     *
     * @param string $content
     */
    public function addBuffer($content, $bufferName = "body")
    {
        // Send $loggedUser to view
        $Session = new Session();
        $this->setData('loggedUser', $Session->get('loggedUser'));

        global $globalSettings;
        $this->setData('globalSettings', $globalSettings);

        if (!isset($this->buffer[$bufferName])) {
            $this->buffer[$bufferName] = array();
        }

        $this->buffer[$bufferName][] = $content;

        return $this->data;
    }

    /**
     * Renders a view
     *
     * @param string $view - file name
     * @return string
     */
    public function renderView($view = '')
    {
        // we redefine the input variables so we can make it harder to overwrite their values from the template
        $__view = $view;

        // if we can't find the view, we throw an exception
        if (!@file_exists($__view)) {
            throw new \Exception(__METHOD__ . ': couldn\'t find file \'' . $__view . '\'.');
        }

        if (!@is_readable($__view)) {
            throw new \Exception(__METHOD__ . ': couldn\'t open file \'' . $__view . '\'.');
        }

        // we prepare the data object to be available to standard echo functions in the template
        foreach (get_object_vars($this->data) as $__idx => $__val) {
            $$__idx = $__val;
        }

        // start output buffering
        ob_start();

        // Send $loggedUser to view file
        $Session = new Session();
        $loggedUser = $Session->get('loggedUser');

        // Modules
        $ModulesModel = new \Application\Modules\ModulesModel();
        $menuModulesTmp = $ModulesModel->getBy();
        foreach ($menuModulesTmp as $menuModule) {
            $menuModules[$menuModule['table']] = $menuModule;
        }

        // Send $globalSettings to view file
        global $globalSettings;
        $globalSettings = $globalSettings;

        include( $__view );

        $buffer = ob_get_clean();

        // return the buffer
        return $buffer;
    }

    /**
     * Converts filename to unix format
     *
     * @param string $file
     * @return string
     */
    public function unixFilename($file)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Replace back-slash with slash
            $_file = str_replace('\\', '/', $file);

            // Replace duplicated // with single /
            return preg_replace('/\/+/i', '/', $_file);
        }

        return $file;
    }

    /**
     * Adds a new javascript to the list of page javascripts
     *
     * @param string $file
     * @return bool
     */
    public function addJs($file)
    {
        if (strlen($file) > 0) {
            $tmp = $this->unixFilename(realpath($file));

            // daca fisierul există, il adaugam in lista, altfel nnu
            if (strlen($tmp) > 0) {
                $this->js[] = $tmp;
            } else {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Adds a new javascript to the list of page javascripts (by URL)
     *
     * @param string $url
     * @return bool
     */
    public function addJsUrl($url)
    {
        if (strlen($url) > 0) {
            $this->js[] = $url . (SettingsModel::get('environment') == 'development' ? '?time='. time() : null);

            return true;
        }

        return false;
    }

    /**
     * Adds javascript inline
     *
     * @param string $text
     * @return boolean
     */
    public function addJsInline($text)
    {
        if (strlen($text) > 0) {
            $this->inlineJs[] = $text;

            return true;
        }

        return false;
    }

    /**
     * Clears the page js
     *
     */
    public function clearJs()
    {
        $this->js = array();

        $this->inlineJs = array();
    }

    /**
     * Adds a new css to the list
     *
     * @param string $file
     * @return bool
     */
    public function addCss($file)
    {
        if (strlen($file) > 0) {
            $filename = realpath($file);
            $tmp = $this->unixFilename(str_replace(BASE_URL, '', $file));

            // daca fisierul există, il adaugam in lista, altfel nnu
            if (strlen($tmp) > 0) {
                $this->css[] = BASE_URL . $tmp;
            } else {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Clears the page Css
     *
     */
    public function clearCss()
    {
        $this->css = array();
    }

    /**
     * Returns the date in string format
     *
     * @return string
     */
    public function getDateString()
    {
        return date('Y/m/d');
    }

    /**
     * Returns a SCRIPT tag for a JS file
     *
     * @param string $file
     * @return string
     */
    function jsLink($file)
    {
        if (preg_match("/^http/", $file)) {
            // JS by URL
            return '<script src="' . $file . '" type="text/javascript"></script>';
        } else {
            // local JS file
            return '<script src="' . _BASE_URL_ . $file . '?v=' . @filemtime($file) . '" type="text/javascript"></script>';
        }
    }

    /**
     * Returns a LINK tag for a CSS file
     *
     * @param string $file
     * @return string
     */
    function cssLink($file)
    {
        return '<link rel="stylesheet" type="text/css" href="'  . $file . '?time=' . time() . '" />';
    }

    /**
     * Returns the URL form of a file/folder
     *
     * @param string $file
     * @return string
     */
    function getFileUrl($file)
    {
        return _BASE_URL_ . str_replace(_APP_DIR_, '', $this->unixfilename(realpath($file)));
    }

    /**
     * Renders the page. If the $noDisplay flag is set to true, the result is not displayed
     *
     * Uses the buffer to display content
     *
     * @param string $layoutFile
     * @param bool $display
     * @return string
     */
    public function renderPage($layoutFile = "template.html.php", $display = true)
    {
        // PAGE HEADER
        $data = new \stdClass();

        $tmpJs = array();
        for ($i = 0; $i < count($this->js); $i++) {
            $js = $this->js[$i];
            $tmpJs[] = ($i > 0 ? "\t" : null) . $this->jsLink($js) ."\n";
        }
        $data->js = join($tmpJs);

        if (!empty($this->inlineJs)) {
            $data->inlineJs = "<script type=\"text/javascript\">" . join("\n", $this->inlineJs) . "</script>\n";
        } else {
            $data->inlineJs = "";
        }

        $tmpCss = array();
        for ($i = 0; $i < count($this->css); $i++) {
            $css = $this->css[$i];
            $tmpCss[] = $this->cssLink($css);
        }
        $data->css = join("\n", $tmpCss);

        $this->setData($data);

        // define and set the session id
        $session = new Session();
        $this->setData('session_id', $session->getSessionId());
        /*         * * END PAGE HEADER ** */

        foreach ($this->buffer as $key => $value) {
            $this->setData($key, join("", $value));
        }

        $pageContent = $this->renderView(ROOT . '/templates/' . $layoutFile);

        // internal variables cleanup
        $this->clearBuffer();
        $this->clearJs();
        $this->clearCss();

        // start output buffering
        ob_start();

        $buffer = ob_get_clean();

        // if the $return flag is false, we display the result
        if ($display === true) {
            echo $pageContent;
        }

        // we clear the data for the next render
        $this->clearData();

        // return the buffer
        return $buffer;
    }

    /**
     * Renders the page. If the $noDisplay flag is set to true, the result is not displayed
     *
     * Uses the buffer to display content
     *
     * @param string $layoutFile
     * @param bool $display
     * @return string
     */
    public function renderTemplate($layoutFile = "template.html.php", $display = true)
    {
        foreach ($this->buffer as $key => $value) {
            $this->setData($key, join("", $value));
        }

        $pageContent = $this->renderView(ROOT . '/templates/' . $layoutFile);

        return $pageContent;
    }

    /**
     * Encodes html entities in a text
     *
     * @param string $text
     * @return string
     */
    public function htmlEntities($text)
    {
        return htmlentities($text, ENT_COMPAT, 'UTF-8');
    }

}