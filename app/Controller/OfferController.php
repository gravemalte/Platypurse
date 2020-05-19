<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;

class OfferController extends BaseController
{
    public function index()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/offer/index.php';
        //require APP . 'View/shared/footer.php';
    }
}
