<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;

class HomeController extends BaseController
{
    /**
     *  index page
     */
    public function index()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/home/index.php';
        //require APP . 'View/shared/footer.php';
    }

    /**
     * testing page
     */
    public function testing()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/footer.php';
    }
}
