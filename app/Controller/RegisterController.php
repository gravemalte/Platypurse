<?php

namespace Controller;

use http\Client\Curl\User;
use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\UserDAO;
use Model\UserModel;
use Hydro\Helper\Date;
use Hydro\Helper\FakeMailer;
use PDOException;

class RegisterController extends BaseController {

    public function index(){
        if (isset($_SESSION['currentUser'])) {
            header('location: ' . URL . 'error/alreadyLoggedIn');
            exit();
        }

        require APP . 'View/shared/header.php';
        require APP . 'View/register/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/register/index.php';
        require APP . 'View/shared/footer.php';
        session_destroy();
    }

    public function register(){
        if(!(isset($_POST["user-email"]) || isset($_POST["user-passwd"])
        || isset($_POST['user-display-name']) || isset($_POST['user-passwd2'])
            || isset($_POST['agb-confirm']))){

            $_SESSION['register-error'] = true;
            header('location:' . URL . 'register');
        }

        $userInputDisplayName = $_POST['user-display-name'];
        $userInputMail = strtolower($_POST['user-email']);



        $userInputPassswd = $_POST['user-passwd'];
        $userInputPassswd2 = $_POST['user-passwd2'];


        if($userInputPassswd != $userInputPassswd2){
            $_SESSION['register-inputName'] = $userInputDisplayName;
            $_SESSION['register-inputMail'] = $userInputMail;
            $_SESSION['register-error-password'] = true;
            header('location:' . URL . 'register');
            die();
        }

        if(!isset($_POST['agb-confirm'])){
            $_SESSION['register-inputName'] = $userInputDisplayName;
            $_SESSION['register-inputMail'] = $userInputMail;
            $_SESSION['register-error-agb'] = true;
            header('location:' . URL . 'register');
            die();
        }

        $defaultImagePath = "assets/nav/user-circle-solid.svg";
        $mime = "image/svg+xml";
        $image = base64_encode(file_get_contents($defaultImagePath));

        $userModel = new UserModel(hexdec(uniqid()),
            $userInputDisplayName,
            $userInputMail,
            password_hash($userInputPassswd, PASSWORD_DEFAULT),
            2,
            0,
            Date::now(),
            $mime,
            $image,
            0,
            0);

        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $userDao = new UserDAO($con);
        try {
            $sqlite->openTransaction();
            $check = $userModel->insertIntoDatabase($userDao);

            $sqlite->closeTransaction($check);

            session_destroy();
            if($check){
                $mail = FakeMailer::sendVerifyMail($userModel);
                header('location: '. URL . 'register/instructionsSent?id=' . $mail->getId());
            } else {
                header('location: '. URL . 'error/databaseError');
            }
        } catch (PDOException $e) {
            $sqlite->closeTransaction(false);
            try {
                $mailUser = UserModel::getFromDatabaseByMail($userDao, $userInputMail);
                if (!empty($mailUser->getId())) {
                    $mail = FakeMailer::sendDuplicateMail($mailUser);
                    header('location: '. URL . 'register/instructionsSent?id=' . $mail->getId());
                }
                else {
                    $nameUser = UserModel::getFromDatabaseByName($userDao, $userInputDisplayName);
                    if (!empty($nameUser->getId())) {
                        $_SESSION['register-error'] = true;
                        header('location: '. URL . 'register');
                    }
                    else {
                        header('location: ' . URL . 'error/databaseError');
                    }
                }
            } catch (PDOException $e) {
                header('location: ' . URL . 'error/databaseError');
            }
        } finally {
            $_SESSION['register-error'] = true;
            $_SESSION['register-inputName'] = $userInputDisplayName;
            $_SESSION['register-inputMail'] = $userInputMail;
            unset($userModel);
        }
    }

    public static function verify() {
        require APP . 'View/shared/header.php';
        require APP . 'View/register/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/shared/footer.php';
    }

    public static function instructionsSent() {
        if (!isset($_GET['id'])) {
            http_response_code(404);
            header('location: ' . URL . 'error/pageNotFound');
            exit();
        }

        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/register/instructionsSent.php';
        require APP . 'View/shared/footer.php';
    }
}
