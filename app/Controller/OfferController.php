<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\OfferModel;

class OfferController extends BaseController
{
    private $offer;


    public function index()
    {
        if(isset($_GET['id'] )){
            $offer = self::getOffer($_GET['id']);
            if($offer == false){
                header('location: ' . URL . 'error');
            }
        }

        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/offer/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/offer/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getOffer($id) {
        return OfferModel::getFromDatabase(COLUMNS_OFFER["o_id"]. " = ?",
            array($id),
            "",
            "",
            "1");
    }

    public static function offerToSavedList() {
        if(isset($_SESSION["currentUser"])):
            $values = array($_SESSION["currentUser"]->getId(), $_POST["offerId"], 1);
            SQLite::insertBuilder(TABLE_SAVED_OFFERS, COLUMNS_SAVED_OFFERS, $values);
        endif;
        header('location: ' . URL);
        exit();
    }

    public static function removeFromSavedList() {
        $values = array($_SESSION["currentUser"]->getId(), $_POST["offerId"], 1);
        $whereClause = COLUMNS_SAVED_OFFERS["u_id"]. " = ? AND "
            .COLUMNS_SAVED_OFFERS["o_id"]. " = ? AND "
            .COLUMNS_SAVED_OFFERS["active"]. " = ?";

        SQLite::deleteBuilder(TABLE_SAVED_OFFERS, $whereClause, $values);
        header('location: ' . URL);
        exit();
    }

    public static function getOfferFromSavedList($offerId) {
        $values = array($_SESSION["currentUser"]->getId(), $offerId, 1);
        $whereClause = COLUMNS_SAVED_OFFERS["u_id"]. " = ? AND "
            .COLUMNS_SAVED_OFFERS["o_id"]. " = ? AND "
            .COLUMNS_SAVED_OFFERS["active"]. " = ?";

        $result = SQLite::selectBuilder(COLUMNS_SAVED_OFFERS,
            TABLE_SAVED_OFFERS,
            $whereClause,
            $values);

        if($result == null):
            return false;
        else:
            return true;
        endif;
    }

    /**
     *
     */
    public function delete() {
        if(!(isset($_SESSION['currentUser']))){
            header('location: ' . URL . 'login');
        }

        // TODO: use table const
        $offer = $this->getOffer($_POST['offerId']);
        if($offer->getPlatypus()->deleteFromDatabase()):
            $offer->deleteFromDatabase();
        endif;
        header('location: ' . URL);
        exit();
    }
}
