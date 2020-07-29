<?php
namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\OfferDAO;
use Model\DAO\UserDAO;
use Model\DAO\UserRatingDAO;
use Model\UserModel;
use Model\OfferModel;
use Model\UserRatingModel;
use PDOException;

class ProfileController extends BaseController
{
    public function index(){

        // only redirect a user to the login page if is not
        // possible to display a user
        if (!isset($_SESSION['currentUser']) && !isset($_GET['id'])) {
            header('location: ' . URL . 'login');
        }

        $_SESSION['csrf_token'] = uniqid();

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

    public static function getUser($id, $dao = null){
        if(!isset($dao)):
            $sqlite = new SQLite();
            $con = $sqlite->getCon();
            $dao = new UserDAO($con);
            $unset = true;
        endif;

        $model = UserModel::getUser($dao, $id);
        if(isset($unset)):
            unset($sqlite);
        endif;

        return $model;
    }

    public static function getDisplayUser() {
      if (isset($_GET['id'])) return ProfileController::getUser($_GET['id']);
      return $_SESSION['currentUser'];
      // if both are not set redirect to login
      // see index()
    }

    public static function getOffersByUserId() {
        $id = ProfileController::getDisplayUser()->getId();
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $model = OfferModel::getFromDatabaseByUserId(new OfferDAO($con),$id);
        unset($sqlite);
        return $model;
    }

    public static function getSavedOffersForCurrentUser() {
        $id = ProfileController::getDisplayUser()->getId();
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $model = OfferModel::getSavedOffersFromDatabaseByUserId(new OfferDAO($con), $id);
        unset($sqlite);
        return $model;
    }

    public static function getUserRating($userId) {
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new UserRatingDAO($con);
        unset($sqlite);
        return UserRatingModel::getRatingFromDatabaseForUserId($dao, $userId);
    }

    public static function getRatedFromUser($fromUserId, $forUserId) {
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new UserRatingDAO($con);
        unset($sqlite);
        return UserRatingModel::getFromDatabaseByFromUserIdAndForUserId(
            $dao, $fromUserId, $forUserId);
    }

    public static function disableUser() {
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new UserDAO($con);
        $user = UserModel::getFromDatabaseById($dao, $_POST['user_id']);

        $user->deactivateInDatabase($dao);
        unset($sqlite);
        header('location: ' . URL . 'profile?id=' . $user->getId());
        exit();
    }

    public static function enableUser() {
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new UserDAO($con);
        $user = UserModel::getFromDatabaseById($dao, $_POST['user_id']);

        $user->activateInDatabase($dao);
        unset($sqlite);
        header('location: ' . URL . 'profile?id=' .$user->getId());
        exit();

    }

    public static function rateUser() {
        if (!isset($_SESSION['currentUser']) || !isset($_POST['csrf']) || ($_POST['csrf'] != $_SESSION['csrf_token'])) {
            http_response_code(401);
            echo "unauthorized";
            return;
        }

        if (!isset($_POST['rating']) || !isset($_POST['rating-user-id'])) {
            http_response_code(400);
            echo "bad request";
            return;
        }

        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new UserRatingDAO($con);
        $rating = UserRatingModel::getFromDatabaseByFromUserIdAndForUserId(
            $dao, $_SESSION['currentUser']->getId(), $_POST['rating-user-id']);
        $rating->setFromUserId($_SESSION['currentUser']->getId());
        $rating->setForUserId($_POST['rating-user-id']);

        $rateValue = $_POST['rating'];
        if ($rateValue <= 5 && $rateValue >= 1) {
            $rateValue = round($rateValue, 0);
        }
        else {
            $rateValue = 0;
        }
        $oldRating = $rating->getRating();
        $rating->setRating($rateValue);

        if (empty ($oldRating)) {
            $rating->insertIntoDatabase($dao);
            return;
        }
        $rating->updateInDatabase($dao);
    }
}