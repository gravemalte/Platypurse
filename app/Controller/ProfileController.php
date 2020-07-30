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
        if(isset($_GET['id'] )){
            $user = self::getDisplayUser();
            if($user == false){
                header('location: ' . URL . 'error/pageNotFound');
            }
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
        try {
            $model = UserModel::getUser($dao, $id);
        } catch (PDOException $ex) {
            if(isset($unset)):
                unset($sqlite);
            endif;
            header('location: ' . URL . 'editProfile');
            exit();
        }
        if(isset($unset)):
            unset($sqlite);
        endif;

        return $model;
    }

    public static function getDisplayUser($dao = null) {
        if (isset($_GET['id'])) return ProfileController::getUser($_GET['id'], $dao);
        return $_SESSION['currentUser'];
        // if both are not set redirect to login
        // see index()
    }

    public static function getOffersByUserId() {
        try {
            $sqlite = new SQLite();
            $con = $sqlite->getCon();
            $id = ProfileController::getDisplayUser(new UserDAO($con))->getId();
            return OfferModel::getFromDatabaseByUserId(new OfferDAO($con),$id);

        } catch (PDOException $ex) {
            header('location: ' . URL . 'error/databaseError');
        } finally {
            unset($sqlite);
        }
    }

    public static function getSavedOffersForCurrentUser() {
        try {
            $sqlite = new SQLite();
            $con = $sqlite->getCon();
            $id = ProfileController::getDisplayUser(new UserDAO($con))->getId();
            return OfferModel::getSavedOffersFromDatabaseByUserId(new OfferDAO($con), $id);

        } catch (PDOException $ex) {
            header('location: ' . URL . 'error/databaseError');
        } finally {
            unset($sqlite);
        }

    }

    public static function getUserRating($userId) {
        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new UserRatingDAO($con);
            return UserRatingModel::getRatingFromDatabaseForUserId($dao, $userId);

        } catch (PDOException $ex) {
            header('location: ' . URL . 'error/databaseError');
        } finally {
            unset($sqlite);
        }
    }

    public static function getRatedFromUser($fromUserId, $forUserId) {
        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new UserRatingDAO($con);
            return UserRatingModel::getFromDatabaseByFromUserIdAndForUserId(
                $dao, $fromUserId, $forUserId);
        } catch (PDOException $ex) {
            header('location: ' . URL . 'error/databaseError');
        } finally {
            unset($sqlite);
        }
    }

    public static function disableUser() {
        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new UserDAO($con);
            $user = UserModel::getFromDatabaseById($dao, $_POST['user_id']);

            $user->deactivateInDatabase($dao);
            header('location: ' . URL . 'profile?id=' . $user->getId());
        } catch (PDOException $ex) {
            header('location: ' . URL . 'error/databaseError');
        } finally {
            unset($sqlite);
        }
    }

    public static function enableUser() {
        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new UserDAO($con);
            $user = UserModel::getFromDatabaseById($dao, $_POST['user_id']);

            $user->activateInDatabase($dao);
            header('location: ' . URL . 'profile?id=' .$user->getId());
            exit();
        } catch (PDOException $ex) {
            header('location: ' . URL . 'error/databaseError');
        } finally {
            unset($sqlite);
        }

    }

    public static function rateUser() {
        if (!isset($_SESSION['currentUser']) || !isset($_POST['csrf']) || ($_POST['csrf'] != $_SESSION['csrf_token']
            || $_SESSION['currentUser']->getId() == $_POST['rating-user-id'])) {
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
        try {
            $rating = UserRatingModel::getFromDatabaseByFromUserIdAndForUserId(
                $dao, $_SESSION['currentUser']->getId(), $_POST['rating-user-id']);
            if(!$rating) {
                $rating = new UserRatingModel(null, "", "", "");
            }
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
            $sqlite->closeTransaction(true);
        }
        catch (PDOException $ex) {
            $sqlite->closeTransaction(false);
            header('location: ' . URL . 'error/databaseError');
        } finally {
            unset($sqlite);
        }
    }

    public static function avatar() {
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new UserDAO($con);
        $user = UserModel::getFromDatabaseById($dao, $_GET['id']);
        header("Content-Type: " . $user->getMime());
        $data = explode(",", $user->getPicture());
        echo base64_decode($data[1]);
    }
}