<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\OfferModel;
use Model\DAO\DAOOffer;

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
        return OfferModel::getNewestOffers(new DAOOffer(SQLite::connectToSQLite()));
    }

    public function getHotOffer() {
        return OfferModel::getHotOffer(new DAOOffer(SQLite::connectToSQLite()));
    }
}
