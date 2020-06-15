<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Model\UserModel;
use Model\OfferGridModel;

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
        $whereClause = COLUMNS_USER["u_id"]. " = ?";
        return UserModel::getFromDatabase($whereClause, array($id));
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

    public function banHammerGo() {
        $user = UserModel::getFromDatabase(COLUMNS_USER['u_id']. " = ?",
            array($_POST['user']));
        $disabled = 0;

        if($user->isDisabled() == 0):
            $disabled = 1;
        endif;

        $user->setDisabled($disabled);
        $user->writeToDatabase();
        header('location: ' . URL . 'profile?id=' .$user->getId());
        exit();
    }

}