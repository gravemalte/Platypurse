<?php


namespace Controller;


class TermsOfUseController
{

    public function index(){
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/terms-of-use/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/terms-of-use/index.php';
        require APP . 'View/shared/footer.php';
    }
}