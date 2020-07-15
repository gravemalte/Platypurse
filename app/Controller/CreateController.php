<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\DAOOffer;
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

    public function processInput() {
        // TODO: Documentation

        if($_POST['csrf'] != $_SESSION['csrf_token']){
            header('location: ' . URL . 'error/unauthorized');
            exit();
        }

        $dao = new DAOOffer(SQLite::connectToSQLite());
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

        $images = array();
        if($imageUpdate):
            // TODO: When gallery is implemented, loop through multiple images
            $mime = $_FILES['image']['type'];
            $image = base64_encode(file_get_contents($_FILES['image']['tmp_name']));
        else:
            $defaultImagePath = "https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg";
            $mime = pathinfo($defaultImagePath)['extension'];
            $image = base64_encode(file_get_contents($defaultImagePath));
        endif;
        $image = new OfferImageModel(hexdec(uniqid()),
            $newOfferId,
            0,
            $mime,
            $image);
        $images[] = $image;

        $newOffer = new OfferModel($newOfferId,
            $offerUser,
            $newPlatypus,
            $this->processInputPrice($_POST["price"]),
            0,
            $_POST['description'],
            $_POST['zipcode'],
            0,
            Date::now(),
            null,
            $images,
            1);

        $con = SQLite::connectToSQLite();
        try {
            $con->beginTransaction();
            $dao = new DAOOffer(SQLite::connectToSQLite());

            if($isUpdate):
                $existingOfferId = $_POST["offerId"];
                $existingOffer = OfferModel::getFromDatabase($dao, $existingOfferId);

                $newPlatypus->setId($existingOffer->getPlatypus()->getId());
                $newPlatypus->setActive($existingOffer->getPlatypus()->isActive());

                $newOffer->setId($existingOffer->getId());
                $newOffer->setUser($existingOffer->getUser());
                $newOffer->setPlatypus($newPlatypus);
                $newOffer->setClicks($existingOffer->getClicks());
                $newOffer->setCreateDate($existingOffer->getCreateDate());
                $newOffer->setEditDate(Date::now());
                $newOffer->setActive($existingOffer->isActive());

                foreach($newOffer->getImages() as $key=>$image):
                    $image->setOfferId($existingOfferId);
                    $image->setId($existingOffer->getImages()[$key]->getId());
                    if(!$imageUpdate):
                        $image->setMime($existingOffer->getImages()[$key]->getMime());
                        $image->setImage($existingOffer->getImages()[$key]->getImage());
                    endif;
                endforeach;
            endif;

            if(!isset($existingOffer) || $offerUser->isAdmin() || $offerUser->getId() == $currentUser->getId()):
                if($isUpdate):
                    $check = $newOffer->updateInDatabase($dao);
                else:
                    $check = $newOffer->insertIntoDatabase($dao);
                endif;

                if($check):
                    $con->commit();
                    header('location: ' . URL . 'offer?id=' . $newOffer->getId());
                    exit();
                endif;
            endif;
        } catch (PDOException $e) {
            // TODO: Error handling
            // print "error go brr";
            $con->rollback();
        }
        header('location: ' . URL . 'offer?id=' .$newOffer->getId());
        exit();
    }

    /**
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
        // print($price);
        return $price;
    }
}
