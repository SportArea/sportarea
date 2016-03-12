<?php

namespace SportArea\Core;

class Router
{
    private $routes;

    public function __construct()
    {
        global $routes;

        $this->routes = ((is_array($routes)) ? $routes : array());

		// parse the URL
		try {
			$route = $this->parseUrl();
		} catch (Exception $e) {
			// if we get a "not found" exception, we return a 404 header and end the execution
			if( preg_match("/method .* not found/i", $e->getMessage()) )
			{
				header("HTTP/1.0 404 Not Found");
				echo $e->getMessage();
				exit;
			}

			throw $e;
		}

		// if we get here, we can do the routing
		require_once($this->getControllerPath($route->module, $route->function));

		$modulename = $this->getModuleClass($route->module);
		$class      = new $modulename;

        $ignored = array('favicon.ico', 'robots.txt');

        if(!in_array($route->function, $ignored)) {
            // dispatch to function
            if(!call_user_func_array(array($class, $route->function), $route->args)) {
                header("HTTP/1.0 404 Not Found");
                exit;
            }
        }
    }

	/**
	 * Parses the URL
	 *
	 * URL format: /module/function/arg1/arg2/...
	 *
	 * Returns an object with the format:
	 *   ->module
	 *   ->function
	 *   ->args
	 *
	 * @return object
	 * @throws Exception
	 */
	public function parseUrl($URI = null)
	{
        $requestURI = (($URI == null) ? $_SERVER['REQUEST_URI'] : $URI);

		// we remove the base URL (application url) from the URI and remove the first and last slashes
		$baseUrl = str_replace("/", "\/", rtrim(BASE_URL, '/'));
        if (strlen($baseUrl) > 0) {
            $tmpUrl = trim(preg_replace("/^" . str_replace("/", "\/", rtrim(BASE_URL, '/')) . "/", '', $requestURI), '/');
        } else {
            $tmpUrl = trim($requestURI, '/');
        }

        $tmpUrlParsed = parse_url($tmpUrl);
        $url = $tmpUrlParsed['path'];

        // we explode the parts by "/"
		//$parts = array_filter(explode("/", $url));
        $parts = explode("/", $url);

        if(count($parts) == 1 && $parts[0] == '') {
            $parts = array();
        }

        //print_r($parts);die;

        // since the URI must have a module and a function part, we stop if we don't find them
		if (count($parts) == 0) {
            $parts = array('index', 'index');

        // If only one part, and routes are not empty
        } else if (count($parts) == 1 AND count($this->routes) != 0) {
           if(array_key_exists($parts[0], $this->routes)) {
               return $this->parseUrl($this->routes[$parts[0]]);
           }
        }

        //print_r($parts);die;

        $return             = new \stdClass();
		$return->module     = $parts[0];
		$return->function   = Utils::lowerCaseToCamelCase($parts[1]);
		$return->args       = array();

        for( $idx = 2; $idx < count($parts); $idx++ ) {
			$return->args[] = $parts[$idx];
		}

        //print_r($return->args);die;

		if(!file_exists($this->getModulePath($return->module))) {
            // TODO: thow exception
            //die("No module named '{$this->getModulePath($return->module)}' found.");
		}

		if(!file_exists($this->getControllerPath($return->module))) {
            // TODO: thow exception
			die('Controller file \'' . $this->getControllerPath($return->module, $return->function) . '\' not found.');
		}

		require_once($this->getControllerPath($return->module, $return->function));

        /**
         * Double call of controller, not cool
         */
        if(false) {
            $moduleName = $this->getModuleClass($return->module);
            $tmp = new $moduleName;

            if(!method_exists($tmp, $return->function) ) {
                // TODO: thow exception
                die('Method '.$return->function.' not found in class '.$moduleName);
            }
        }

		return $return;
	}

    /**
     * Return the module path by name
     *
     * @param   string  $module
     * @return  string
     */
	public function getModulePath($module)
	{
        $moduleFixed = Utils::lowerCaseToCamelCase($module);
        return (ROOT . '/Application/'. ucfirst($moduleFixed) .'/'. ucfirst($moduleFixed) . 'Model.php');
	}

	public function getControllerPath($module)
	{
        $moduleFixed = Utils::lowerCaseToCamelCase($module);
        return (ROOT . '/Application/'. ucfirst($moduleFixed) .'/'. ucfirst($moduleFixed) . 'Controller.php');
	}

	public function getModuleClass($module)
    {
        $moduleFixed = Utils::lowerCaseToCamelCase($module);
        return 'Application\\'. $moduleFixed .'\\'. ucfirst($moduleFixed) . 'Controller';
    }

}