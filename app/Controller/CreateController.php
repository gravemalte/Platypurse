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
        $stmntPlatypus = "UPDATE platypus SET name = ?,
            sex = ?,
            age_years = ?,
            size = ?
        WHERE p_id = ".$_POST['platypusId'].";";
        $valuesPlatypus = array($_POST['name'], $_POST['sex'], $_POST['age'], $_POST['size']);

        $stmntOffer = "UPDATE offer SET price = ?,
            negotiable = ?,
            description = ?
        WHERE o_id = ".$_POST['offerId'].";";
        $valuesOffer = array($_POST['price'], 0, $_POST['description']);
            
        SQLite::update($stmntPlatypus, $valuesPlatypus);
        SQLite::update($stmntOffer, $valuesOffer);

        header('location: ' . URL);
        exit();
    }
}
