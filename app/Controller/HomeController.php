<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Model\OfferModel;

class HomeController extends BaseController
{
    /**
     *  index page
     */
    public function index()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/home/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/home/index.php';
        require APP . 'View/shared/footer.php';
    }

    public function getNewestOffers() {
        return OfferModel::getNewestOffers();
    }

    public function getHotOffer() {
        return OfferModel::getHotOffer();
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
