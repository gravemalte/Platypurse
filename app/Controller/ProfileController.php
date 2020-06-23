<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
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
        $whereClause = "WHERE " .COLUMNS_USER["u_id"]. " = ?";
        return UserModel::getFromDatabase(SQLite::connectToSQLite(), $whereClause, array($id));
    }

    public static function getDisplayUser() {
      if (isset($_GET['id'])) return ProfileController::getUser($_GET['id']);
      return $_SESSION['currentUser'];
      // if both are not set redirect to login
      // see index()
    }

    public static function getOffersFromUser() {
        $id = ProfileController::getDisplayUser()->getId();
        $whereClause = "WHERE " .COLUMNS_OFFER["u_id"]. " = ? AND "
            .TABLE_OFFER.".".COLUMNS_OFFER["active"]. " = ?";


        return OfferModel::getFromDatabase(SQLite::connectToSQLite(), $whereClause, array($id, 1));
    }

    public static function getSavedOffers() {
        $whereClause = "LEFT JOIN " .TABLE_SAVED_OFFERS. " on " .TABLE_OFFER. "." .COLUMNS_OFFER['o_id'].
            " = " .TABLE_SAVED_OFFERS. "." .COLUMNS_SAVED_OFFERS['o_id']. " INNER JOIN " .TABLE_PLATYPUS.
            " on " .TABLE_OFFER. "." .COLUMNS_OFFER['p_id']. " = " .TABLE_PLATYPUS. "." .COLUMNS_PLATYPUS['p_id'].
            " WHERE " .TABLE_SAVED_OFFERS. "." .COLUMNS_SAVED_OFFERS['u_id']. " = ?";


        $id = ProfileController::getDisplayUser()->getId();

        return OfferModel::getFromDatabase(SQLite::connectToSQLite(), $whereClause,
            array($id));
    }

    public static function disableUser() {
        $user = UserModel::getFromDatabase(SQLite::connectToSQLite(), "WHERE " .COLUMNS_USER['u_id']. " = ?",
            array($_POST['user']));

        $user->deactivateInDatabase();
        header('location: ' . URL . 'profile?id=' .$user->getId());
        exit();
    }

    public static function enableUser() {
        $user = UserModel::getFromDatabase(SQLite::connectToSQLite(),"WHERE " .COLUMNS_USER['u_id']. " = ?",
            array($_POST['user']));

        $user->activateInDatabase();
        header('location: ' . URL . 'profile?id=' .$user->getId());
        exit();

    }
}