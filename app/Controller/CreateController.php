<?php
namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\OfferDAO;
use Model\OfferImageModel;
use Model\OfferModel;
use Model\PlatypusModel;
use Hydro\Helper\Date;
use PDOException;

class CreateController extends BaseController
{
    public function index()
    {
        if(!(isset($_SESSION['currentUser']))){
            header('location: ' .URL . 'login');
        }
        $_SESSION['csrf_token'] = uniqid();

        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/create/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/create/index.php';
        require APP . 'View/shared/footer.php';
    }

    /**
     * Process the form data and insert or update the new offer
     */
    public function processInput() {
        if($_POST['csrf'] != $_SESSION['csrf_token']){
            header('location: ' . URL . 'error/unauthorized');
            exit();
        }

        $newOfferId = hexdec(uniqid());
        $isUpdate = isset($_POST["offerId"]);
        $imageUpdate = file_exists($_FILES['image']['tmp_name']);

        $currentUser = $_SESSION['currentUser'];
        $offerUser = $currentUser;

        $newPlatypus = new PlatypusModel(hexdec(uniqid()),
            $_POST["name"],
            $_POST["age"],
            $_POST["sex"],
            $_POST["size"],
            $_POST["weight"],
            1);

        if($imageUpdate):
            $mime = $_FILES['image']['type'];
            $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
        else:
            $mime = "";
            $image = "";
        endif;
        $image = new OfferImageModel(hexdec(uniqid()),
            $newOfferId,
            0,
            $mime,
            $image);

        $negotiable = 0;
        if (isset($_POST['negotiable'])) {
            $negotiable = 1;
        }
        $newOffer = new OfferModel($newOfferId,
            $offerUser,
            $newPlatypus,
            $this->processInputPrice($_POST["price"]),
            $negotiable,
            $_POST['description'],
            $_POST['zipcode'],
            0,
            Date::now(),
            null,
            $image,
            1);

        $sqlite = new SQLite();
        try {
            $sqlite->openTransaction();
            $con = $sqlite->getCon();
            $dao = new OfferDAO($con);

            if($isUpdate):
                $existingOfferId = $_POST["offerId"];
                $existingOffer = OfferModel::getFromDatabase($dao, $existingOfferId);

                $newPlatypus->setId($existingOffer->getPlatypus()->getId());
                //$newPlatypus->setActive($existingOffer->getPlatypus()->isActive());

                $newOffer->setId($existingOffer->getId());
                $newOffer->setUser($existingOffer->getUser());
                $newOffer->setPlatypus($newPlatypus);
                $newOffer->setClicks($existingOffer->getClicks());
                $newOffer->setCreateDate($existingOffer->getCreateDate());
                $newOffer->setEditDate(Date::now());
                //$newOffer->setActive($existingOffer->isActive());

                $newOffer->getImage()->setOfferId($existingOfferId);
                $newOffer->getImage()->setId($existingOffer->getImage()->getId());
                if(!$imageUpdate):
                    $newOffer->getImage()->setMime($existingOffer->getImage()->getMime());
                    $newOffer->getImage()->setImage($existingOffer->getImage()->getImage());
                endif;
            endif;

            if(!isset($existingOffer) || $offerUser->isAdmin() || $offerUser->getId() == $currentUser->getId()):
                if($isUpdate):
                    $check = $newOffer->updateInDatabase($dao);
                else:
                    $check = $newOffer->insertIntoDatabase($dao);
                endif;

                $sqlite->closeTransaction($check);
                if($check):
                    header('location: ' . URL . 'offer?id=' . $newOffer->getId());
                    exit();
                else:
                    die(header('location: ' . URL . 'error/databaseError'));
                endif;
            endif;
        } catch (PDOException $e) {
            $sqlite->closeTransaction(false);
            die(header('location: ' . URL . 'error/alreadyLoggedIn'));
        }
        unset($sqlite);
        header('location: ' . URL . 'offer?id=' . $newOffer->getId());
        exit();
    }

    /**
     * Formats price for use in database
     * @param $price
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
        return $price;
    }
}
