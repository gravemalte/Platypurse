<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Helper\DataSerialize;
use Model\OfferModel;

class OfferController extends BaseController
{
    private $offer;


    public function index()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/offer/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/offer/index.php';
        require APP . 'View/shared/footer.php';
    }

    public function delete() {
        // print($_SESSION["offerId"]);
        OfferModel::deleteOfferFromFile($_SESSION["offerId"]);
        $_SESSION["offerId"] = "";
        header('location: ' . URL);
        exit();
    }
}
