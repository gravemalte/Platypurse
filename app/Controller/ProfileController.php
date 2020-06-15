<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Model\OfferGridModel;
use Model\OfferModel;
use Model\UserModel;

class ProfileController extends BaseController
{
    public function index(){

        // only redirect a user to the login page if is not
        // possible to display a user
        if (!isset($_SESSION['currentUser']) && !isset($_GET['id'])) {
            header('location: ' . URL . 'login');
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

    public static function getDisplayUser() {
      if (isset($_GET['id'])) return ProfileController::getUser($_GET['id']);
      return $_SESSION['currentUser'];
      // if both are not set redirect to login
      // see index()
    }

    public static function getOffersFromUser() {
        $id = ProfileController::getDisplayUser()->getId();
        $whereClause = COLUMNS_OFFER["u_id"]. " = ? AND "
            .TABLE_OFFER.".".COLUMNS_OFFER["active"]. " = ?";
        return OfferGridModel::getFromDatabase(OfferGridModel::TABLE, $whereClause, array($id, 1));
    }

    public static function getSavedOffers() {
        $id = ProfileController::getDisplayUser()->getId();
        $whereClause = TABLE_SAVED_OFFERS.".".COLUMNS_SAVED_OFFERS["u_id"]. " = ?";
        return OfferGridModel::getFromDatabase(OfferGridModel::TABLEJOINSAVEDOFFERS,
            $whereClause,
            array($id));
    }

}