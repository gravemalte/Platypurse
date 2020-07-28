<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;

class LegalNoticeController extends BaseController
{

    public function index(){
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/legal-notice/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/legal-notice/index.php';
        require APP . 'View/shared/footer.php';
    }
}