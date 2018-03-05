<?php
/*
 * This file is part of the Loop-Framework package.
 *
 * (c) Luis Alberto <albertoluis0108@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LoopFM\Core;

use \Exception;
use LoopFM\Lib\Ajax;
use LoopFM\Lib\Http\Header;
use RouterException;

/**
 * Router
 *
 * @package    Loop Sandbox Framework
 * @author     Luis Alberto <albertoluis0108@gmail.com>
 */

class Router
{
    /**
	*
    * @ Registry
	*
    */
    private $registry;

	/**
	*
    * @ store configs from registry
	*
    */
    private $configs;

	/**
	*
    * @ stores controllers path
	*
    */
    private $path;

	/**
	*
    * @ stores controllers name from path
	*
    */
    public $controller;

	/**
	*
    * @ stores controller's method
	*
    */
    public $method;

	/**
	*
    * @ Stores args from route. Example: /controller/method/arg1/arg2/arg3
	*
    */
    public $args;

    /**
	*
    * @ bool for api call
	*
    */
    public $api_call;

    /**
     *
     * @ holds the file path to controller
     *
     */
    private $file;

    /**
    *
    * @constructor
    *
    * @access public
    *
    * @return void
    *
    */
    function __construct($registry) {
        $this->registry = $registry;
		$this->configs = $this->registry->configs;
    }

    /**
    *
    * @set controller directory path
    *
    * @param string $path
    *
    * @return void
    *
    */
    function setPath($path)
	{
        if (!is_dir($path)) {
            throw new Exception ('Invalid Path: `' . $path . '`');
        }
        $this->path = $path;
    }

    /**
    *
    * @ loads the controller
    *
    * @access public
    *
    * @return void
    *
    */
    public function loader()
	{
        $this->getController();
	
        if (!is_readable($this->file)) {
            if ($this->api_call) {
                Header::err404();
                die();
            } else {
                $default_path = $this->path . '/indexController.php';
                if (!is_readable($default_path)) {
                    throw new RouterException(RouterException::CONTROLLER_FILE_NOT_FOUND);
                } else {
                    Header::location('/');
                }
            }			
        }

        if ($this->api_call && !$this->jsonApplicationHeader()) {
            echo 'Wrong api call';
            Header::err403();
            die();
        }
        include $this->file;

        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);

        if (!is_callable(array($controller, $this->method))) {
            $method = 'index';
        } else {
            $method = $this->method;
        }
        $controller->$method();
    }

    /**
    *
    * @ get Controller from route
    *
    * @access private
    *
    * @return void
    *
    */
    private function getController() {

        $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];
        $api = '';

        if (empty($route)) {
            $this->controller = 'index';
        } else {            
            $parts = explode('/', $route);

            if ($parts[0] == 'api') {
                unset($parts[0]);
                $parts = array_values($parts);
                $api = 'api';
                $this->api_call = true;
            }
            $this->controller = strtolower($parts[0]);
			unset($parts[0]);

            if (isset($parts[1])) {
                $this->method = strtolower($parts[1]);
				unset($parts[1]);
            }
            if (!empty($parts)) {
				$this->args = array_values($parts);
            }
        }
        if (empty($this->controller)) {
            $this->controller = 'index';
        }
        if (empty($this->method)) {
            $this->method = 'index';
        }
        $this->file = $this->path . '/';
        $this->file .= !empty($api) ? $api.'/' : '';
        $this->file .=$this->controller .'Controller.php';
    }


    /**
     * Get route args from path
     * Ex: /controller/method/arg0/arg1/arg3
     * geArgs returns: [arg1,arg2,arg3]
     * @param null $index - if not null, attempt to retrieve a single index from args
     * @return null|mixed
     */
    public function getArgs($index = null)
    {
        if (!is_null($index) && $this->args)
            return (
                array_key_exists($index, $this->args) ?
                   $this->args[$index] : null
            );
        else
            return $this->args;
    }

    public function jsonApplicationHeader()
    {
        $header = Header::request('content-type');
        return $header && $header == 'application/json';
    }
}
