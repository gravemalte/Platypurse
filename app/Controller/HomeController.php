<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Model\OfferModel;
use Model\OfferGridModel;
use Model\HotOfferModel;

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
        $whereClause = COLUMNS_OFFER['active']. " = ?";
        $orderClause = COLUMNS_OFFER['create_date']. " desc";
        $limitClause = "9";

        return OfferGridModel::getFromDatabase($whereClause,
            array(1),
            "",
            $orderClause,
            $limitClause);
    }

    public function getHotOffer() {
        return HotOfferModel::getFromDatabase();
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
