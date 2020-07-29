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

    /**
     * Returns all offers matching the parameters
     *
     * @param int $offset exclude number of matches. By default 0
     * @param string $like matches name or description partially. By default empty
     * @param string $sex of platypus. By default empty
     * @param int[] $age array with min and max age. By default [0, 20]
     * @param int[] $size array with min and max size. By default [0, 20]
     * @param int[] $weight array with min and max weight. By default [0, 3000]
     * @return array[] matches in offer table
     */
    public static function getOffers($offset = 0, $like = "", $sex = "", $age = array(0, 20), $size = array(0, 20),
                                     $weight = array(0, 3000)) {
        $keyedSearchValuesArray = array(
            "name" => "%" .htmlspecialchars($like). "%",
            "description" => "%" .htmlspecialchars($like). "%",
            "ageMin" => min($age),
            "ageMax" => max($age),
            "sizeMin" => min($size),
            "sizeMax" => max($size),
            "weightMin" => min($weight),
            "weightMax" => max($weight),
            "limit" => 30,
            "offset" => $offset);

        if(!empty($sex)):
            $keyedSearchValuesArray['sex'] = $sex;
        endif;

        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $offerDao = new OfferDAO($con);
        $model = OfferModel::getSearchResultsFromDatabase($offerDao, $keyedSearchValuesArray);
        unset($sqlite);
        return $model;
    }
}
