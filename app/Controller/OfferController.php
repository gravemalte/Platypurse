<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\DAOOffer;
use Model\DAO\DAOSavedOffers;
use Model\OfferModel;
use Model\SavedOfferModel;

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
        return OfferModel::getFromDatabase(new DAOOffer(SQLite::connectToSQLite()), $id);
    }

    public static function offerToSavedList() {
        if(isset($_SESSION["currentUser"])):
            $dao = new DAOSavedOffers(SQLite::connectToSQLite());
            $userId = $_SESSION["currentUser"]->getId();
            $offerId = $_POST["offerId"];

            $savedOffer = SavedOfferModel::getFromDatabaseByUserIdAndOfferId($dao, $userId, $offerId, false);
            if(empty($savedOffer->getId())):
                $savedOffer = new SavedOfferModel(hexdec(uniqid()),
                    $userId, $offerId, 1);

                $insertRow = $savedOffer->insertIntoDatabase($dao);
                // TODO: Check why this below works
                $check = empty($insertRow[0]);
            else:
                $savedOffer->setActive(1);
                $check = $savedOffer->updateInDatabase($dao);
            endif;

            if($check):
                header('location: ' . URL . 'profile?id=' . $userId);
                exit();
            endif;
        endif;
        header('location: ' . URL . 'login');
        exit();
    }

    public static function removeFromSavedList() {
        $userId = $_SESSION["currentUser"]->getId();
        $offerId = $_POST["offerId"];
        $dao = new DAOSavedOffers(SQLite::connectToSQLite());

        $savedOffer = SavedOfferModel::getFromDatabaseByUserIdAndOfferId($dao, $userId, $offerId, true);
        $savedOffer->setActive(0);

        $check = $savedOffer->updateInDatabase($dao);

        header('location: ' . URL . 'profile?id=' . $userId);
        exit();
    }

    public static function isOfferInSavedList($offerId) {
        $userId = $_SESSION["currentUser"]->getId();
        $dao = new DAOSavedOffers(SQLite::connectToSQLite());

        $savedOffer = SavedOfferModel::getFromDatabaseByUserIdAndOfferId($dao, $userId, $offerId, true);

        if(empty($savedOffer->getId())):
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
