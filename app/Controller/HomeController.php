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
        $result = SQLite::select("SELECT o_id, name, price, negotiable, description FROM offer as o INNER JOIN platypus as p ON o.p_id = p.p_id WHERE o.active = 1 ORDER BY o.create_date desc");
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
        $result = SQLite::select("SELECT o_id, name, price, negotiable, description, sex, age_years, age_months, size, clicks FROM offer as o INNER JOIN platypus as p ON o.p_id = p.p_id WHERE o.active = 1 ORDER BY o.clicks desc LIMIT 1");
        $return = "";

        foreach($result as $row) {
            $return = new HotOfferModel($row['o_id'],
                $row['name'],
                $row['price'],
                $row['negotiable'],
                $row['description'],
                $row['sex'],
                $row['age_years'],
                $row['age_months'],
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
