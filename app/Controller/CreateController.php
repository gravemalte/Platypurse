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

    public function create(){
        $offerName = $_POST["name"];
        $offerDescription = $_POST["description"];
        $offerPrice = $_POST["price"];
        $offerCategories = $_POST["sex"];
        $offer = new OfferModel($offerName, $offerDescription, $offerPrice, $offerCategories);

        $offer->createOffer($offer);
        header('location: ' . URL);
        exit();
    }
}
