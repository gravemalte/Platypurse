<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;

class ProfileController extends BaseController
{
    public function index(){
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/profile/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/profile/index.php';
        require APP . 'View/shared/footer.php';
    }


}