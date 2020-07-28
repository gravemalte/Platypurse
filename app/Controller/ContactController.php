<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;

class ContactController extends BaseController
{

    public function index(){
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/contact/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/contact/index.php';
        require APP . 'View/shared/footer.php';
    }
}