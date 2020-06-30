<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\DAOOffer;
use Model\DAO\DAOUser;
use Model\UserModel;
use Model\OfferModel;

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

    public static function edit() {
        if (isset($_GET['id'])) {
            header('location: ' . URL . 'editProfile?id=' . $_GET['id']);
            exit();
        }
        header('location: ' . URL . 'editProfile');
    }

    public static function getUser($id){
        return UserModel::getUser($id);
    }

    public static function getDisplayUser() {
      if (isset($_GET['id'])) return ProfileController::getUser($_GET['id']);
      return $_SESSION['currentUser'];
      // if both are not set redirect to login
      // see index()
    }

    public static function getOffersByUserId() {
        $id = ProfileController::getDisplayUser()->getId();
        return OfferModel::getFromDatabaseByUserId(new DAOOffer(SQLite::connectToSQLite()),$id);
    }

    public static function getSavedOffersForCurrentUser() {
        $id = ProfileController::getDisplayUser()->getId();
        return OfferModel::getSavedOffersFromDatabaseByUserId(new DAOOffer(SQLite::connectToSQLite()), $id);
    }

    public static function disableUser() {
        $dao = new DAOUser(SQLite::connectToSQLite());
        $user = UserModel::getFromDatabaseById($dao, $_POST['user_id']);

        $user->deactivateInDatabase($dao);
        header('location: ' . URL . 'profile?id=' . $user->getId());
        exit();
    }

    public static function enableUser() {
        $dao = new DAOUser(SQLite::connectToSQLite());
        $user = UserModel::getFromDatabaseById($dao, $_POST['user_id']);

        $user->activateInDatabase($dao);
        header('location: ' . URL . 'profile?id=' .$user->getId());
        exit();

    }
}