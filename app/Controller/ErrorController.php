<?php


namespace Controller;


class ErrorController
{

    public function index(){
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/error/404.php';
        require APP . 'View/shared/footer.php';
    }
}