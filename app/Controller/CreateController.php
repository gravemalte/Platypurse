<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\OfferModel;
use Model\PlatypusModel;
use Hydro\Helper\Date;

class CreateController extends BaseController
{
    public function index()
    {
        if(!(isset($_SESSION['currentUser']))){
            header('location: ' .URL . 'login');
        }
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/create/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/create/index.php';
        require APP . 'View/shared/footer.php';
    }

    /**
     * @param $id
     * @return OfferModel|string
     */
    public function getOffer($id) {
        return OfferController::getOffer($id);
    }

    public function processInput() {
        $existingOffer = null;


        $currentUser = $_SESSION['currentUser'];
        $platypusId = hexdec(uniqid());
        $offerId = hexdec(uniqid());
        $userId = $currentUser->getId();
        $createDate = Date::now();

        if(isset($_POST["offerId"])):
            $offerId = $_POST["offerId"];
            $existingOffer = OfferModel::getFromDatabase(SQLite::connectToSQLite(), "WHERE " .COLUMNS_OFFER['o_id']. " = ?",
                array($offerId))[0];
        endif;

        if(!isset($existingOffer) ||$currentUser->getId() == $existingOffer->getUser()->getId()
            || $currentUser->isAdmin()):

            $platypus = new PlatypusModel($platypusId,
                $_POST["name"],
                $_POST["age"],
                $_POST["sex"],
                $_POST["size"],
                $_POST["weight"],
                1);

            $imageArray = array();
            if(file_exists($_FILES['image']['tmp_name'])):
                $imageDataArray[COLUMNS_OFFER_IMAGES['mime']] = $_FILES['image']['type'];
                $imageDataArray[COLUMNS_OFFER_IMAGES['image']] = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
                $imageArray[] = $imageDataArray;
            else:
                $defaultImagePath = "https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg";
                $imageDataArray[COLUMNS_OFFER_IMAGES['mime']] =pathinfo($defaultImagePath)['extension'];
                $imageDataArray[COLUMNS_OFFER_IMAGES['image']] = base64_encode(file_get_contents($defaultImagePath));
                $imageArray[] = $imageDataArray;
            endif;

            $offer = new OfferModel($offerId,
                $currentUser,
                $platypus,
                $this->processInputPrice($_POST["price"]),
                0,
                $_POST['description'],
                $imageArray);

            if(!empty($existingOffer)):
                $platypus->setId($existingOffer->getPlatypus()->getId());

                $offer->setClicks($existingOffer->getClicks());
                $offer->setCreateDate($existingOffer->getCreateDate());
            endif;

            $offer->writeToDatabase();
        endif;
        header('location: ' . URL . 'offer?id=' .$offerId);
        exit();
    }

    /**
     * @param $price input price
     * @return float|int|string formatted price
     */
    private function processInputPrice($price) {
        if(strpos($price, ",") || strpos($price, ".")):
            $limiter = "";
            if(strpos($price, ",")): $limiter = ","; endif;
            if(strpos($price, ".")): $limiter = "."; endif;

            $priceExploded = explode($limiter, $price);
            if(end($priceExploded) != "00" || end($priceExploded) != "0"):
                if(strlen(end($priceExploded)) == 1):
                    $priceExploded[1] *= 10;
                endif;
                $price = implode("", $priceExploded);
            else:
                $price = $priceExploded[0]*100;
            endif;
        else:
            $price *= 100;
        endif;
        // print($price);
        return $price;
    }
}
