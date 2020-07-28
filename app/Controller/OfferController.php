<?php
namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\OfferDAO;
use Model\DAO\SavedOffersDAO;
use Model\OfferModel;
use Model\SavedOfferModel;
use PDOException;

class OfferController extends BaseController
{
    public function index()
    {
        if(isset($_GET['id'] )){
            $offer = self::getOffer($_GET['id']);
            if($offer == false){
                header('location: ' . URL . 'error/pageNotFound');
            }
        }

        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/offer/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/offer/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getOffer($id, $offerDAO = null) {
        if(!isset($offerDAO)):
            $sqlite = new SQLite();
            $con = $sqlite->getCon();
            $offerDAO = new OfferDAO($con);
        endif;
        return OfferModel::getFromDatabase($offerDAO, $id);
    }

    public static function offerToSavedList() {
        if(isset($_SESSION["currentUser"])):
            $userId = $_SESSION["currentUser"]->getId();
            $offerId = $_POST["offerId"];

            $sqlite = new SQLite();
            try {
                $sqlite->openTransaction();
                $con = $sqlite->getCon();
                $dao = new SavedOffersDAO($con);

                $savedOffer = SavedOfferModel::getFromDatabaseByUserIdAndOfferId($dao, $userId, $offerId, false);
                if(!$savedOffer || empty($savedOffer->getId())):
                    $savedOffer = new SavedOfferModel(hexdec(uniqid()),
                        $userId, $offerId, 1);

                    $check = $savedOffer->insertIntoDatabase($dao);
                else:
                    $savedOffer->setActive(1);
                    $check = $savedOffer->updateInDatabase($dao);
                endif;

                $sqlite->closeTransaction($check);
                if($check):
                    header('location: ' . URL . 'profile?id=' . $userId);
                    exit();
                else:
                    header('location: ' . URL . 'error/databaseError');
                    exit();
                endif;
            } catch (PDOException $e) {
                $sqlite->closeTransaction(false);
                header('location: ' . URL . 'error/databaseError');
                exit();
            }
        endif;
        header('location: ' . URL . 'login');
        exit();
    }

    public static function removeFromSavedList() {
        $userId = $_SESSION["currentUser"]->getId();
        $offerId = $_POST["offerId"];

        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $sqlite->openTransaction();
            $dao = new SavedOffersDAO($con);

            $savedOffer = SavedOfferModel::getFromDatabaseByUserIdAndOfferId($dao, $userId, $offerId, true);
            $savedOffer->setActive(0);

            $check = $savedOffer->updateInDatabase($dao);


            $sqlite->closeTransaction($check);
        } catch (PDOException $e) {
            $sqlite->closeTransaction(false);
            header('location: ' . URL . 'error/databaseError');
            exit();
        }

        header('location: ' . URL . 'profile?id=' . $userId);
        exit();
    }

    public static function isOfferInSavedList($offerId) {
        $userId = $_SESSION["currentUser"]->getId();
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new SavedOffersDAO($con);

        $savedOffer = SavedOfferModel::getFromDatabaseByUserIdAndOfferId($dao, $userId, $offerId, true);

        if(!$savedOffer || empty($savedOffer->getId())):
            return false;
        else:
            return true;
        endif;
    }

    public static function offerClickPlusOne($offer) {
        $sqlite = new SQLite();

        try {
            $sqlite->openTransaction();
            $con = $sqlite->getCon();
            $dao = new OfferDAO($con);
            $offer->offerClickPlusOne($dao);
            $sqlite->closeTransaction(true);
        } catch (PDOException $e) {
            $sqlite->closeTransaction(true);
            header('location: ' . URL . 'error/databaseError');
            exit();
        }
    }

    /**
     *
     */
    public function delete() {
        if(!(isset($_SESSION['currentUser']))){
            header('location: ' . URL . 'login');
        }

        $sqlite = new SQLite();
        try {
            $sqlite->openTransaction();
            $con = $sqlite->getCon();

            $dao = new OfferDAO($con);
            $offer = $this->getOffer($_POST['offerId'], $dao);
            $check = $offer->deactivateInDatabase($dao);
            $sqlite->closeTransaction($check);
        } catch (PDOException $e) {
            $sqlite->closeTransaction(false);
            header('location: ' . URL . 'error/databaseError');
            exit();
        }

        header('location: ' . URL);
        exit();
    }
}
