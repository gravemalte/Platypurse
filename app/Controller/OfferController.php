<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Model\OfferModel;

class OfferController extends BaseController
{
    private $offer;


    public function index()
    {
        if(isset($_GET['id'] )){
            $offer = self::getOffer($_GET['id']);
            if($offer == false){
                header('location: ' . URL . 'error');
            }
        }

        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/offer/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/offer/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getOffer($id) {
        return OfferModel::getFromDatabase(OfferModel::TABLECOLUMNS["o_id"]. " = ?",
            array($id),
            "",
            "",
            "1");
    }

    /**
     *
     */
    public function delete() {
        if(!(isset($_SESSION['currentUser']))){
            header('location: ' . URL . 'login');
        }

        // TODO: use table const
        $offer = $this->getOffer($_POST['offerId']);
        if($offer->getPlatypus()->deleteFromDatabase()):
            $offer->deleteFromDatabase();
        endif;
        header('location: ' . URL);
        exit();
    }
}
