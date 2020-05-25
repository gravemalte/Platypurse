<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;

class CreateController extends BaseController
{
    public function index()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/create/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/create/index.php';
        require APP . 'View/shared/footer.php';
    }
}
