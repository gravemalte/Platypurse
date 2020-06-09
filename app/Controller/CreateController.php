<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\OfferModel;
use Model\PlatypusModel;
use Controller\OfferController;

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

    /**
     *
     */
    public function create() {
        $price = $_POST['price'];
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

        $platypus = new PlatypusModel(hexdec(uniqid()),
            $_POST["name"],
            $_POST["age"],
            $_POST["sex"],
            $_POST["size"]);
        $platypus->insertIntoDatabase();

        if($platypus->insertIntoDatabase()):
            $offer = new OfferModel(hexdec(uniqid()),
                $_SESSION['currentUser']->getId(),
                $platypus,
                $price,
                0,
                $_POST['description']);
            $offer->writeToDatabase();
        else:
        endif;
        header('location: ' . URL);
        exit();
    }

    /**
     *
     */
    public function update(){
        $preparedSetPlatypus = PlatypusModel::TABLECOLUMNS["name"]." = ?,
            " .PlatypusModel::TABLECOLUMNS["sex"]." = ?,
            " .PlatypusModel::TABLECOLUMNS["age_years"]." = ?,
            " .PlatypusModel::TABLECOLUMNS["size"]." = ?";
        $preparedWherePlatypus = PlatypusModel::TABLECOLUMNS["p_id"]." = ?";
        $valuesPlatypus = array($_POST['name'], $_POST['sex'], $_POST['age'], $_POST['size'], $_POST['platypusId']);

        SQLite::updateBuilder(PlatypusModel::TABLE, $preparedSetPlatypus, $preparedWherePlatypus, $valuesPlatypus);

        $preparedSetOffer = OfferModel::TABLECOLUMNS["price"]." = ?,
            " .OfferModel::TABLECOLUMNS["negotiable"]." = ?,
            " .OfferModel::TABLECOLUMNS["description"]." = ?";
        $preparedWhereOffer = OfferModel::TABLECOLUMNS["o_id"]." = ?";
        $valuesOffer = array($_POST['price'], 0, $_POST['description'], $_POST['offerId']);

        SQLite::updateBuilder(OfferModel::TABLE, $preparedSetOffer, $preparedWhereOffer, $valuesOffer);

        header('location: ' . URL);
        exit();
    }
}
