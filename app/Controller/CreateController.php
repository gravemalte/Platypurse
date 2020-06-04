<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Model\OfferModel;

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

    public function getOfferFromData($id = "") {
        $offerName = $_POST["name"];
        $offerDescription = $_POST["description"];
        $offerPrice = $_POST["price"];
        $sex = $_POST["sex"];
        $age = $_POST["age"];
        $size = $_POST["size"];

        return new OfferModel($offerName, $offerDescription, $offerPrice, $sex, $age, $size, $id);
    }

    public function create() {
        $offer = CreateController::getOfferFromData();

        $offer->createOffer($offer);
        header('location: ' . URL);
        exit();
    }

    public function update(){
        $offer = CreateController::getOfferFromData($_POST['offerId']);

        $offer->updateOffer($offer);
        header('location: ' . URL);
        exit();
    }
}
