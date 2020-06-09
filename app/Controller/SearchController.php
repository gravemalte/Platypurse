<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Model\OfferGridModel;
use Model\OfferModel;
use Model\PlatypusModel;

class SearchController extends BaseController
{
    public function index(){
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/search/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/search/index.php';
        require APP . 'View/shared/footer.php';
    }


    public function getOffers($like = "", $sex = "", $age = array(0, 20), $size = array(0, 20)) {
        $whereClause = PlatypusModel::TABLECOLUMNS['name']. " LIKE ? 
        AND ".PlatypusModel::TABLECOLUMNS['age_years']." BETWEEN ? and ?
        AND ".PlatypusModel::TABLECOLUMNS['size']." BETWEEN ? and ?
        AND ".OfferModel::TABLECOLUMNS['active']." = 1";
        $values = array("%" .$like. "%", min($age), max($age), min($size), max($size));

        if(!empty($sex)):
            $whereClause .= " AND ".PlatypusModel::TABLECOLUMNS['sex']. " = ?";
            $values[] = $sex;
        endif;

        return OfferGridModel::getFromDatabase($whereClause, $values);
    }
}