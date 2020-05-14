<?php

namespace Controller;

use Platypurse\Base\Controller\BaseController;

class HomeController extends BaseController
{
    /**
     *  index page
     */
    public function index()
    {
        // load views
        require APP . 'view/shared/header.php';
        require APP . 'view/shared/footer.php';
        require APP . 'view/home/index.php';
    }

    /**
     * testing page
     */
    public function testing()
    {
        // load views
        require APP . 'view/shared/header.php';
        require APP . 'view/shared/footer.php';
    }
}
