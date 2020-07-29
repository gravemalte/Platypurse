<?php
namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\OfferDAO;
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

    /**
     * Returns the newest offers
     * @return array
     */
    public static function getNewestOffers() {
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $models = OfferModel::getNewestOffers(new OfferDAO($con));
        unset($sqlite);
        return $models;
    }

    /**
     * Returns the hot offer
     * @return OfferModel
     */
    public static function getHotOffer() {
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $model = OfferModel::getHotOffer(new OfferDAO($con));
        unset($sqlite);
        return $model;
    }
}
