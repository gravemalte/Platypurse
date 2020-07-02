<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\DAOOffer;
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
        /*$whereClause = "INNER JOIN platypus ON platypus.p_id = offer.p_id WHERE " .COLUMNS_PLATYPUS['name']. " LIKE ?
        AND ".COLUMNS_PLATYPUS['age_years']." BETWEEN ? and ?
        AND ".COLUMNS_PLATYPUS['size']." BETWEEN ? and ?
        AND ".COLUMNS_PLATYPUS['weight']." BETWEEN ? and ?
        AND ".TABLE_OFFER.".".COLUMNS_OFFER['active']." = 1";*/
        $keyedSearchValuesArray = array(
            "name" => "%" .htmlspecialchars($like). "%",
            "ageMin" => min($age),
            "ageMax" => max($age),
            "sizeMin" => min($size),
            "sizeMax" => max($size),
            "weightMin" => min($weight),
            "weightMax" => max($weight));

        if(!empty($sex)):
            $keyedSearchValuesArray["sex"] = $sex;
        endif;

        $offerDao = new DAOOffer(SQLite::connectToSQLite());
        return OfferModel::getSearchResultsFromDatabase($offerDao, $keyedSearchValuesArray);
    }
}