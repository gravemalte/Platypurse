<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Helper\DataSerialize;
use Model\OfferModel;

class HomeController extends OfferGridController
{
    /**
     *  index page
     */
    public function index()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/home/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/home/index.php';
        require APP . 'View/shared/footer.php';
    }

    /**
     * testing page
     */
    public function testing()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/footer.php';
    }

    public function getHotOffer() {
        $offerData = DataSerialize::unserializeData(OfferModel::getData("5ed2b0e211d7c"));
        $returnStr = "";

        foreach($offerData as $offer) {
            $returnStr = "
            <a href=\"offer?id=".$offer->getId()."\">
                <div class=\"hot-offer-container card\">
                    <div class=\"annotation\">
                        <p>Hot Offer</p>
                    </div>                
                    <div class=\"hot-offer\">
                        <div class=\"img-container\">
                            <img src=\"https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg\" alt=\"hot offer image\">
                        </div>
                        <div class=\"side-text\">
                            <h1 class=\"name\">".$offer->getTitle()."</h1>
                            <p class=\"description\">".$offer->getDescription()."</p>
                            <div class=\"attribute-list\">
                                <p>".$offer->getCategories()."</p>
                            </div>
                            <h2 class=\"view-counter\">123</h2>
                            <p class=\"view-description\">Aufrufe in den letzten 24H</p>
                        </div>
                        <div class=\"price-tag\">
                            <p>".$offer->getPrice()."</p>
                        </div>
                    </div>
                </div>
            </a>";
        }
        return $returnStr;
    }
}
