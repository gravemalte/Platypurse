<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\OfferModel;

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


    public static function getOffers($like = "", $sex = "", $age = array(0, 20), $size = array(0, 20), $weight = array(0, 3000)) {
        $whereClause = "INNER JOIN platypus ON platypus.p_id = offer.p_id WHERE " .COLUMNS_PLATYPUS['name']. " LIKE ? 
        AND ".COLUMNS_PLATYPUS['age_years']." BETWEEN ? and ?
        AND ".COLUMNS_PLATYPUS['size']." BETWEEN ? and ?
        AND ".COLUMNS_PLATYPUS['weight']." BETWEEN ? and ?
        AND ".TABLE_OFFER.".".COLUMNS_OFFER['active']." = 1";
        $values = array("%" .$like. "%", min($age), max($age), min($size), max($size), min($weight), max($weight));

        if(!empty($sex)):
            $whereClause .= " AND ".COLUMNS_PLATYPUS['sex']. " = ?";
            $values[] = $sex;
        endif;

        return OfferModel::getFromDatabase(SQLite::connectToSQLite(), $whereClause, $values);
    }
}