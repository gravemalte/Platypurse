<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Model\UserModel;

class EditProfileController extends BaseController {

    public function index() {
        // you need to be logged in to edit-profile your profile
        if (!isset($_SESSION['currentUser'])) {
            header('location: ' . URL . 'login');
        }
        // only admins can use specific id to edit-profile user profiles
        if (isset($_GET['id']) && !$_SESSION['currentUser']->isAdmin()) {
            header('location: ' . URL . 'editProfile');
        }

        require APP . 'View/shared/header.php';
        require APP . 'View/edit-profile/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/edit-profile/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getUser() {
        $id = $_SESSION['currentUser']->getId();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        return ProfileController::getUser($id);
    }

    public static function update() {

        if (!isset($_GET['id']) || !isset($_SESSION['currentUser'])) {
            header('location: ' . URL . 'error');
            exit();
        }

        $id = $_GET['id'];
        $user = ProfileController::getUser($id);
        $currentUser = $_SESSION['currentUser'];

        if (!($currentUser->isAdmin() || $id == $currentUser->getId())) {
            header('location: ' . URL . 'login');
            exit();
        }

        $possibleChanges = array('display-name', 'email', 'password');
        foreach ($possibleChanges as $possibleChange) {
            if (isset($_GET[$possibleChange])) {
                if (!empty($_GET[$possibleChange])) {
                    switch ($possibleChange) {
                        case $possibleChanges[0]:
                            $user->setDisplayName($_GET[$possibleChange]);
                            break;
                        case $possibleChanges[1]:
                            $user->setMail($_GET[$possibleChange]);
                            break;
                        case $possibleChanges[2]:
                            $user->setPassword($_GET[$possibleChange]);
                            break;
                    }
                }
            }
        }

        $user->updateInDatabase();

        if ($currentUser->getId() == $id) {
            $_SESSION['currentUser'] = $user;
        }

        header('location: ' . URL . 'profile/edit?id=' . $id);
    }

}