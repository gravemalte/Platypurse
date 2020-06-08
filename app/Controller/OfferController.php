<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\OfferModel;
use Model\PlatypusModel;

class OfferController extends BaseController
{
    private $offer;


    public function index()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/offer/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/offer/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getOffer($id) {
        $result = SQLite::select("SELECT * FROM offer INNER JOIN platypus ON offer.p_id = platypus.p_id WHERE o_id = ".$id);
        $return = "";

        foreach($result as $row) {
            $return = new OfferModel($row['o_id'],
                $row['u_id'],
                new PlatypusModel(
                    $row['p_id'],
                    $row['name'],
                    $row['age_years'],
                    $row['sex'],
                    $row['size']),
                $row['price'],
                $row['negotiable'],
                $row['description'],
                $row['clicks'],
                $row['create_date'],
                $row['edit_date'],
                $row['active']);
        }
        return $return;

    }

    public function delete() {
        if(!(isset($_SESSION['user-ID']))){
            header('location: ' . URL . 'login');
        }

        SQLite::deleteBuilder(OfferModel::TABLE, "o_id = ?;", array($_POST['offerId']));
        SQLite::deleteBuilder(PlatypusModel::TABLE, "p_id = ?;", array($_POST['platypusId']));

        header('location: ' . URL);
        exit();
    }
}
