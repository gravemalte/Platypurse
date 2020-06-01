<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Helper\DataSerialize;
use Model\OfferModel;

class CreateController extends BaseController
{
    public function index()
    {
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

    public function create(){
        $offer = getOfferFromData();

        $offer->createOffer($offer);
        header('location: ' . URL);
        exit();
    }

    public function update($id){
        $offer = getOfferFromData($id);

        $offer->updateOffer($offer);
        header('location: ' . URL);
        exit();
    }
}
