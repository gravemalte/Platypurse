<?php
namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\OfferDAO;
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
        $keyedSearchValuesArray = array(
            "name" => "%" .htmlspecialchars($like). "%",
            "description" => "%" .htmlspecialchars($like). "%",
            "ageMin" => min($age),
            "ageMax" => max($age),
            "sizeMin" => min($size),
            "sizeMax" => max($size),
            "weightMin" => min($weight),
            "weightMax" => max($weight));

        if(!empty($sex)):
            $keyedSearchValuesArray["sex"] = $sex;
        endif;

        $offerDao = new OfferDAO(SQLite::connectToSQLite());
        return OfferModel::getSearchResultsFromDatabase($offerDao, $keyedSearchValuesArray);
    }
}
