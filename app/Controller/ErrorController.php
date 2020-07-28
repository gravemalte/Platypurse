<?php


namespace Controller;


class ErrorController
{

    public function index(){
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/error/pageNotFound.php';
        require APP . 'View/shared/footer.php';
    }

    public function pageNotFound(){

        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/error/pageNotFound.php';
        require APP . 'View/shared/footer.php';
    }

    public function subpageNotFound(){
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/error/subPageNotFound.php';
        require APP . 'View/shared/footer.php';
    }

    public function alreadyLoggedIn(){
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/error/alreadyLoggedIn.php';
        require APP . 'View/shared/footer.php';
    }

    public function alreadyLoggedOut(){
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/error/alreadyLoggedOut.php';
        require APP . 'View/shared/footer.php';
    }

    public function unauthorized(){
        session_destroy();
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/error/unauthorized.php';
        require APP . 'View/shared/footer.php';
    }

    public function databaseError(){
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/error/databaseError.php';
        require APP . 'View/shared/footer.php';
    }

    public function mailContentError(){

    }



}