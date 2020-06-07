<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\OfferGridModel;

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
        $query = "SELECT o_id, name, price, negotiable, description FROM platypus
            INNER JOIN offer ON platypus.p_id = offer.p_id
            WHERE name LIKE '%".$like."%'
            AND age_years BETWEEN ".min($age)." and ".max($age)."
            AND size BETWEEN ".min($size)." and ".max($size);

        if(!empty($sex)):
            $query .= " AND sex = '".$sex."';";
        endif;

        $result = SQLite::select($query);
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