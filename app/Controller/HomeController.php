<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\OfferModel;
use Model\PlatypusModel;
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
        $selectedValues = array(OfferModel::TABLE.".".OfferModel::TABLECOLUMNS["o_id"],
            PlatypusModel::TABLECOLUMNS["name"],
            OfferModel::TABLECOLUMNS["price"],
            OfferModel::TABLECOLUMNS["negotiable"],
            OfferModel::TABLECOLUMNS["description"]);

        $fromClause = OfferModel::TABLE." INNER JOIN " .PlatypusModel::TABLE. " ON "
            .OfferModel::TABLE. "." .OfferModel::TABLECOLUMNS["p_id"]. " = "
            .PlatypusModel::TABLE. "." .PlatypusModel::TABLECOLUMNS["p_id"];

        $whereClause = OfferModel::TABLECOLUMNS['active']. " = ?";
        $orderClause = OfferModel::TABLECOLUMNS['create_date']. " desc";
        $limitClause = "9";

        $values = array(1);

        $result = SQLite::selectBuilder($selectedValues,
            $fromClause,
            $whereClause,
            $values,
            "",
            $orderClause,
            $limitClause);
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

    public function getHotOffer() {
        // WHERE o.active = 1 ORDER BY o.clicks desc LIMIT 1"
        $selectedValues = array(OfferModel::TABLE.".".OfferModel::TABLECOLUMNS["o_id"],
            PlatypusModel::TABLECOLUMNS["name"],
            OfferModel::TABLECOLUMNS["price"],
            OfferModel::TABLECOLUMNS["negotiable"],
            OfferModel::TABLECOLUMNS["description"],
            PlatypusModel::TABLECOLUMNS["sex"],
            PlatypusModel::TABLECOLUMNS["age_years"],
            PlatypusModel::TABLECOLUMNS["size"],
            OfferModel::TABLECOLUMNS["clicks"]);

        $fromClause = OfferModel::TABLE." INNER JOIN " .PlatypusModel::TABLE. " ON "
            .OfferModel::TABLE. "." .OfferModel::TABLECOLUMNS["p_id"]. " = "
            .PlatypusModel::TABLE. "." .PlatypusModel::TABLECOLUMNS["p_id"];

        $whereClause = OfferModel::TABLECOLUMNS['active']. " = ?";
        $orderClause = OfferModel::TABLECOLUMNS['clicks']. " desc";
        $limitClause = "1";

        $values = array(1);

        $result = SQLite::selectBuilder($selectedValues,
            $fromClause,
            $whereClause,
            $values,
            "",
            $orderClause,
            $limitClause);
        $return = array();

        foreach($result as $row) {
            $return = new HotOfferModel($row['o_id'],
                $row['name'],
                $row['price'],
                $row['negotiable'],
                $row['description'],
                $row['sex'],
                $row['age_years'],
                $row['size'],
                $row['clicks']);
        }

        return $return;
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
