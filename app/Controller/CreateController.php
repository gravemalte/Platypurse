<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Model\OfferModel;
use Model\PlatypusModel;

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
        $currentUser = $_SESSION['currentUser'];
        $platypusId = hexdec(uniqid());
        $offerId = hexdec(uniqid());
        $userId = $currentUser->getId();

        if(isset($_POST["offerId"])):
            $offerId = $_POST["offerId"];
            $offer = OfferModel::getFromDatabase(COLUMNS_OFFER['o_id']. " = ?",
                array($offerId));

            if(!empty($offer)):
                $platypusId = $offer->getPlatypus()->getId();
                $userId = $offer->getUserId();
            endif;
        endif;

        if(empty($offer) || $currentUser->getId() == $offer->getUserId()
            || $currentUser->isAdmin()):

            $platypus = new PlatypusModel($platypusId,
                $_POST["name"],
                $_POST["age"],
                $_POST["sex"],
                $_POST["size"],
                $_POST["weight"],
                1);

            $offer = new OfferModel($offerId,
                $userId,
                $platypus,
                $this->processInputPrice($_POST["price"]),
                0,
                $_POST['description']);



            if($platypus->writeToDatabase()):
                $offer->writeToDatabase();
            endif;
        endif;
        header('location: ' . URL . 'offer?id='.$offerId);
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
