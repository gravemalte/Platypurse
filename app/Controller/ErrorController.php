<?php


namespace Controller;


class ErrorController
{

    public function index(){
        require APP . 'View/error/404.php';
    }

}