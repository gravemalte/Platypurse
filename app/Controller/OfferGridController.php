<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Helper\DataSerialize;
use Model\OfferModel;

class OfferGridController extends BaseController
{
    private function index()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/offer/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/offer/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getDataAsGrid($searchStr = "") {
        $dataArray = OfferModel::getData($searchStr);
        // print_r($dataArray);
        $unserializeData = DataSerialize::unserializeData($dataArray);
        // print_r($unserializeData);

        $offerGrid = "";
        if(!empty($unserializeData)) {
            foreach($unserializeData as $offer) {
                $offerGrid .= "<a class=\"offer-list-link\" href=\"offer?id=".$offer->getId()."\">
                <div class=\"offer-list-item card\">
                    <img src=\"https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg\" alt=\"\">
                    <p class=\"name\">".$offer->getTitle()."</p>
                    <p class=\"description\">".$offer->getDescription()."</p>
                    <div class=\"price-tag-container\">
                        <p class=\"price-tag\">".$offer->getPrice()."</p>
                    </div>
                </div>
                </a>";
                //echo $offer->getTitle();
            }
        }

        return $offerGrid;
    }
}
