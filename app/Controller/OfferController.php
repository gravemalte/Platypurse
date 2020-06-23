<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\OfferModel;
use Model\PlatypusModel;
use Model\UserModel;

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
        return OfferModel::getFromDatabase(SQLite::connectToSQLite(),  "WHERE " .COLUMNS_OFFER["o_id"]. " = ?",
            array($id))[0];
    }

    public static function offerToSavedList() {
        if(isset($_SESSION["currentUser"])):
            $con = SQLite::connectToSQLite();
            $userId = $_SESSION["currentUser"]->getId();
            $values = array($userId, $_POST["offerId"], 1);

            $statement = "INSERT INTO " .TABLE_SAVED_OFFERS. " (";
            foreach (COLUMNS_SAVED_OFFERS as $col):
                $statement .= $col .", ";
            endforeach;
            $statement = substr($statement, 0, -2) .") VALUES (";
            foreach ($values as $val):
                $statement .= "?, ";
            endforeach;
            $statement = substr($statement, 0, -2) .");";

            //print($statement);
            //print_r($specialCharsValueArray);

            $command = $con->prepare($statement);
            if($command->execute($values)):
                header('location: ' . URL . 'profile?id=' . $userId);
                exit();
            endif;
        endif;
        header('location: ' . URL . 'login');
        exit();
    }

    public static function removeFromSavedList() {
        $userId = $_SESSION["currentUser"]->getId();
        $con = SQLite::connectToSQLite();
        $statement = "DELETE FROM " .TABLE_SAVED_OFFERS. " WHERE "
            .COLUMNS_SAVED_OFFERS["u_id"]. " = ? AND "
            .COLUMNS_SAVED_OFFERS["o_id"]. " = ? AND "
            .COLUMNS_SAVED_OFFERS["active"]. " = ?";
        $values = array($_SESSION["currentUser"]->getId(), $_POST["offerId"], 1);

        $command = $con->prepare($statement);
        $command->execute($values);
        header('location: ' . URL . 'profile?id=' . $userId);
        exit();
    }

    public static function isOfferInSavedList($offerId) {
        $con = SQLite::connectToSQLite();
        $statement = "SELECT * FROM " .TABLE_SAVED_OFFERS. " WHERE "
            .COLUMNS_SAVED_OFFERS["u_id"]. " = ? AND "
            .COLUMNS_SAVED_OFFERS["o_id"]. " = ? AND "
            .COLUMNS_SAVED_OFFERS["active"]. " = ?";
        $values = array($_SESSION["currentUser"]->getId(), $offerId, 1);

        $command = $con->prepare($statement);
        $command->execute($values);

        if(count($command->fetchAll()) == 0):
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

        $offer = $this->getOffer($_POST['offerId']);
        $offer->deactivateInDatabase();
        header('location: ' . URL);
        exit();
    }
}
