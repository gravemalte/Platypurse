<?php


use Controller\HomeController;
use Model\UserModel;


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
            // TODO: Rework the header response #2
            } else {
                if (strlen($this->url_action) == 0) {
                    $this->url_controller->index();
                } else {
                    $error = new \Controller\ErrorController();
                    $error->index();
                }
            }
        } else {
            $error = new \Controller\ErrorController();
            $error->index();
        }
    }

    public static function getInstance(){
        if(self::$instance == null){
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

            // debugging dirty as shit
            /*echo '<div class="debugging">';
            echo '<h1>DEBUGGING OUTPUT</h1>';
            echo '<h2>Controller responded the following object:</h2>';
            echo '<p>Controller: ' . $this->url_controller . '<br>';
            echo '<p>Action: ' . $this->url_action . '<br>';
            echo '<p>Parameters: ' . print_r($this->url_params, true) . '<br></p>';
            echo '</div>';*/

        }
    }
}
