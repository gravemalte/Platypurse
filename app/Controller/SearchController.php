<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;

class SearchController extends BaseController
{
    public function index(){
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/footer.php';
        require APP . 'View/search/index.php';
    }


}