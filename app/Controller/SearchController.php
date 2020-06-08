<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
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
        $selectedValues = array(OfferModel::TABLE.".".OfferModel::TABLECOLUMNS["o_id"],
            PlatypusModel::TABLECOLUMNS["name"],
            OfferModel::TABLECOLUMNS["price"],
            OfferModel::TABLECOLUMNS["negotiable"],
            OfferModel::TABLECOLUMNS["description"]);

        $fromClause = OfferModel::TABLE." INNER JOIN " .PlatypusModel::TABLE. " ON "
            .OfferModel::TABLE. "." .OfferModel::TABLECOLUMNS["p_id"]. " = "
            .PlatypusModel::TABLE. "." .PlatypusModel::TABLECOLUMNS["p_id"];

        $whereClause = PlatypusModel::TABLECOLUMNS['name']. " LIKE ? 
        AND ".PlatypusModel::TABLECOLUMNS['age_years']." BETWEEN ? and ?
        AND ".PlatypusModel::TABLECOLUMNS['size']." BETWEEN ? and ?";
        $values = array("%" .$like. "%", min($age), max($age), min($size), max($size));

        if(!empty($sex)):
            $whereClause .= " AND ".PlatypusModel::TABLECOLUMNS['sex']. " = ?";
            $values[] = $sex;
        endif;


        $result = SQLite::selectBuilder($selectedValues,
            $fromClause,
            $whereClause,
            $values);
        $return = array();

        foreach($result as $row) {
            $return[] = new OfferGridModel($row['o_id'],
                $row['name'],
                $row['price'],
                $row['negotiable'],
                $row['description']);
        }
        return $return;
    }
}