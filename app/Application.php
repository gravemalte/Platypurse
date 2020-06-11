<?php

use Controller\HomeController;
use Controller\ErrorController;

class Application
{
    private static $instance = null;

    const CONTROLLER = 'Controller';
    const PHP_FILE_ENDING = '.php';

    private $url_controller = null;
    private $url_action = null;
    private $url_params = array();

    private function __construct()
    {

        // splitting up our URL
        $this->splitUrl();

        // checks if the current controller is null
        // Rewriting the logic see issue #13
        if (!$this->url_controller) {

            $page = new HomeController();
            $page->index();

        } elseif (file_exists(APP . 'Controller/' . ucfirst($this->url_controller) .
            self::CONTROLLER . self::PHP_FILE_ENDING)) {

            $controller = "\\Controller\\" . ucfirst($this->url_controller) . self::CONTROLLER;
            $this->url_controller = new $controller();


            if (method_exists($this->url_controller, $this->url_action)) {

                if (!empty($this->url_params)) {
                    call_user_func_array(array($this->url_controller, $this->url_action), $this->url_params);
                } else {
                    $this->url_controller->{$this->url_action}();
                }
            } else {
                if (strlen($this->url_action) == 0) {
                    $this->url_controller->index();
                } else {
                    $error = new ErrorController();
                    $error->index();
                }
            }
        } else {
            $error = new ErrorController();
            $error->index();
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Application();
        }

        return self::$instance;
    }

    private function splitUrl()
    {
        if (isset($_GET['url'])) {

            // splitting our URL
            $url = trim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->url_controller = isset($url[0]) ? $url[0] : null;
            $this->url_action = isset($url[1]) ? $url[1] : null;

            unset($url[0], $url[1]);

            $this->url_params = array_values($url);
        }
    }
}
