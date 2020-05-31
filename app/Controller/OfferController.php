<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
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

        $this->offer = OfferModel::getData($_GET['id']);
    }

    public function deleteOffer() {

    }

    public function getTitle() {
        return $this->offer.getTitle();
    }
}
