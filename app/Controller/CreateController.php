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
        if(!(isset($_SESSION['user-ID']))){
            header('location: ' .URL . 'login');
        }
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/create/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/create/index.php';
        require APP . 'View/shared/footer.php';
    }

    public function getOffer($id) {
        return OfferController::getOffer($id);
    }

    public function create() {
        $platypus = new PlatypusModel(hexdec(uniqid()),
            $_POST["name"],
            $_POST["age"],
            4,
            $_POST["sex"],
            $_POST["size"]);
        $platypus->writeToDatabase();

        if($platypus->writeToDatabase()):
            $offer = new OfferModel(hexdec(uniqid()),
                $_SESSION['user-ID'],
                $platypus,
                $_POST['price'],
                0,
                $_POST['description']);
            $offer->writeToDatabase();
        else:
        endif;
        header('location: ' . URL);
        exit();
    }

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
        $preparedWhereOffer = PlatypusModel::TABLECOLUMNS["o_id"]." = ?";
        $valuesOffer = array($_POST['price'], 0, $_POST['description'], $_POST['offerId']);

        SQLite::updateBuilder(OfferModel::TABLE, $preparedSetOffer, $preparedWhereOffer, $valuesOffer);

        header('location: ' . URL);
        exit();
    }
}
