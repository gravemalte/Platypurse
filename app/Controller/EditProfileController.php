<?php
namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\UserDAO;
use PDOException;

class EditProfileController extends BaseController {

    public function index() {
        // you need to be logged in to edit-profile your profile
        if (!isset($_SESSION['currentUser'])) {
            header('location: ' . URL . 'login');
        }
        // only admins can use specific id to edit-profile user profiles
        if (isset($_POST['id']) && !$_SESSION['currentUser']->isAdmin()) {
            header('location: ' . URL . 'editProfile');
        }

        $_SESSION['csrf_token'] = uniqid();

        require APP . 'View/shared/header.php';
        require APP . 'View/edit-profile/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/edit-profile/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getUser() {
        $id = $_SESSION['currentUser']->getId();
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        return ProfileController::getUser($id);
    }

    public static function update() {
        if (!isset($_POST['id']) || !isset($_SESSION['currentUser'])) {
            header('location: ' . URL . 'error');
            exit();
        }

        if($_POST['csrf'] != $_SESSION['csrf_token']){
            header('location: ' . URL . 'error');
            die();
        }

        $id = $_POST['id'];
        $currentUser = $_SESSION['currentUser'];

        if (!($currentUser->isAdmin() || $id == $currentUser->getId())) {
            header('location: ' . URL . 'login');
            die();
        }

        $con = SQLite::connectToSQLite();
        try {
            $con->beginTransaction();
            $dao = new UserDAO($con);

            $user = ProfileController::getUser($id, $dao);

            if (!($currentUser->isAdmin() || $id == $currentUser->getId())) {
                header('location: ' . URL . 'login');
                exit();
            }

            $possibleChanges = array('display-name', 'email', 'password');
            foreach ($possibleChanges as $possibleChange) {
                if (isset($_POST[$possibleChange])) {
                    if (!empty($_POST[$possibleChange])) {
                        switch ($possibleChange) {
                            case $possibleChanges[0]:
                                $user->setDisplayName($_POST[$possibleChange]);
                                break;
                            case $possibleChanges[1]:
                                $user->setMail($_POST[$possibleChange]);
                                break;
                            case $possibleChanges[2]:
                                $user->setPassword($_POST[$possibleChange]);
                                break;
                        }
                    }
                }
            }

            if(file_exists($_FILES['image']['tmp_name'])):
                $user->setMime($_FILES['image']['type']);
                $user->setImage(base64_encode(file_get_contents($_FILES['image']['tmp_name'])));
            endif;

            $user->updateInDatabase($dao);

            if ($currentUser->getId() == $id) {
                $_SESSION['currentUser'] = $user;
            }
            $con->commit();
            header('location: ' . URL . 'profile/edit?id=' . $id);
        } catch (PDOException $e) {
            // TODO: Error handling
            // print "error go brr";
            $con->rollback();
            header('location: ' . URL . 'error');
        }
    }

}