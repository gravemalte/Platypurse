<?php


use Controller\HomeController;


class Application
{
    const PHP_FILE_ENDING = '.php';

    private $url_controller = null;

    private $url_action = null;

    private $url_params = array();

    public function __construct()
    {
        // splitting up our URL
        $this->splitUrl();

        // check for controller: no controller given ? then load start-page
        if (!$this->url_controller) {

            $page = new HomeController();
            $page->index();

        } elseif (file_exists(APP . 'Controller/' . ucfirst($this->url_controller) . 'Controller.php')) {

            $controller = "\\Controller\\" . ucfirst($this->url_controller) . 'Controller';
            $this->url_controller = new $controller();


            // check for method: does such a method exist in the controller ?
            if (method_exists($this->url_controller, $this->url_action)) {

                if (!empty($this->url_params)) {
                    call_user_func_array(array($this->url_controller, $this->url_action), $this->url_params);
                } else {
                    $this->url_controller->{$this->url_action}();
                }

            } else {
                if (strlen($this->url_action) == 0) {
                    // no action defined: call the default index() method of a selected controller
                    $this->url_controller->index();
                }
                else {
                    header('location: ' . URL . 'problem');
                }
            }
        } else {
            header('location: ' . URL . 'problem');
        }
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

            // for debugging. uncomment this if you have problems with the URL
            echo '<div class="debugging">';
            echo '<h1>DEBUGGING OUTPUT</h1>';
            echo '<h2>Controller responded the following object:</h2>';
            echo '<p>Controller: ' . $this->url_controller . '<br>';
            echo '<p>Action: ' . $this->url_action . '<br>';
            echo '<p>Parameters: ' . print_r($this->url_params, true) . '<br></p>';
            echo '</div>';

        }
    }
}
