<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;

class TermsOfUseController extends BaseController
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