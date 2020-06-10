<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Model\OfferGridModel;
use Model\OfferModel;
use Model\UserModel;

class ProfileController extends BaseController
{
    public function index(){

        if(!(isset($_SESSION['currentUser']))) {
            header('location: ' . URL . 'login');
        }

        if(!(isset($_GET['id']))){
            header('location: ' . URL . 'error');
        }


        if(isset($_GET['id'] )){
            $user = self::getUser($_GET['id']);
            if($user == false){
                header('location: ' . URL . 'error');
            }
        }

        require APP . 'View/shared/header.php';
        require APP . 'View/profile/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/profile/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getUser($id){
       return UserModel::searchUser($id);
    }

    public static function getOffersFromUser($id) {
        $whereClause = COLUMNS_OFFER["o_id"]. " = ? AND "
            .TABLE_OFFER.".".COLUMNS_OFFER["active"]. " = ?";
        return OfferGridModel::getFromDatabase(OfferGridModel::TABLE, $whereClause, array($id, 1));
    }

    public static function getSavedOffers($id) {
        $whereClause = TABLE_SAVED_OFFERS.".".COLUMNS_SAVED_OFFERS["u_id"]. " = ?";
        return OfferGridModel::getFromDatabase(OfferGridModel::TABLEJOINSAVEDOFFERS,
            $whereClause,
            array($id));
    }

}