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

        //$this->offer = OfferModel::getData($_GET['id'])->getTitle();
    }

    public function getOffer($id) {
        $offerData = DataSerialize::unserializeData(OfferModel::getData($id));
        $returnStr = "";
        foreach($offerData as $offer) {
            $returnStr = "<div class=\"offer-container card\">
                <img src=\"https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg\" alt=\"offer image\">
                <div class=\"description-container\">
                    <p class=\"name\">".$offer->getTitle()."</p>
                    <p class=\"description\">".$offer->getDescription()."</p>
                </div>
                <div class=\"price-tag-container\">
                    <div class=\"price-tag\">
                        <p>".$offer->getPrice()."</p>
                    </div>
                </div>
            </div>
            <div class=\"side-container\">
                <div class=\"offer-buttons-container\">
                    <a href=\"chat\" class=\"send-message-button button\">
                        <div>
                            <p>Nachricht schreiben</p>
                        </div>
                    </a>
                    <a href=\"profile\" class=\"view-profile-button button\">
                        <div>
                            <p>Verkäuferprofil</p>
                        </div>
                    </a>
                    <a href=\"profile\" class=\"save-offer-button button\">
                        <div>
                            <p>Zur Merkliste</p>
                        </div>
                    </a>
                </div>
                <div class=\"attribute-list card\">
                    <div class=\"attribute-item\">
                        <p>".$offer->getCategories()."</p>
                    </div>
                </div>
                <div class=\"offer-interactions-container\">

                    <a href=\"offer/deleteOffer\" class=\"delete-button button\">
                        <div>
                            <span class=\"fas fa-trash-alt\"></span>
                        </div>
                    </a>
                    <a href=\"create?id=<?php OfferController::getId() ?>\" class=\"edit-button button\">
                        <div>
                            <span class=\"fas fa-pencil-alt\"></span>
                        </div>
                    </a>
                </div>
            </div>";
        }

        return $returnStr;
    }

    public function deleteOffer() {

    }

    public function getTitle() {
        return $this->offer.getTitle();
    }
}
