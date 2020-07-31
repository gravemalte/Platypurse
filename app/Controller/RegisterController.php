<?php

namespace Controller;

use DateTime;
use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\RegisterTokenDAO;
use Model\DAO\UserDAO;
use Model\RegisterTokenModel;
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

        $random = random_int(1, 6);
        $defaultImagePath = "assets/placeholder/avatar" . $random . ".png";
        $mime = "image/png";
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
                    if ($mailUser->isVerified()) {
                        $mail = FakeMailer::sendDuplicateMail($mailUser);
                    }
                    else {
                        $mailUser->setDisplayName($userModel->getDisplayName());
                        $mailUser->setPassword($userModel->getPassword(), false);
                        $mailUser->updateInDatabase($userDao);
                        $mail = FakeMailer::sendVerifyMail($mailUser);
                    }
                    header('location: '. URL . 'register/instructionsSent?id=' . $mail->getId());
                }
                else {
                    $nameUser = UserModel::getFromDatabaseByName($userDao, $userInputDisplayName);
                    if (!empty($nameUser->getId())) {
                        $_SESSION['register-error'] = true;
                        header('location: '. URL . 'register');
                    }
                    else {
                        die(header('location: ' . URL . 'error/databaseError'));
                    }
                }
            } catch (PDOException $e) {
                die(header('location: ' . URL . 'error/databaseError'));
            }
        } finally {
            $_SESSION['register-error'] = true;
            $_SESSION['register-inputName'] = $userInputDisplayName;
            $_SESSION['register-inputMail'] = $userInputMail;
            unset($userModel);
            unset($sqlite);
        }
    }

    public static function verify() {
        if (!isset($_GET['token'])) {
            http_response_code(404);
            header('location: ' . URL . 'error/pageNotFound');
            exit();
        }

        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new RegisterTokenDAO($con);
            $token = RegisterTokenModel::getFromDatabaseByToken($dao, $_GET['token']);

            if(is_bool($token)){
                header('location: ' . URL . 'error/databaseError');
                exit();
            }


            $user = $token->getUser();


            require APP . 'View/shared/header.php';
            require APP . 'View/register/header.php';
            require APP . 'View/shared/nav.php';

            $expirationDate = new DateTime($token->getExpirationDate());
            $nowDate = new DateTime("now");
            if ($expirationDate >= $nowDate) {
                $user->verify(new UserDAO($con));
                $token->deleteForUserFromDatabase($dao, $user->getId());
                require APP . 'View/register/verifySuccess.php';
            }
            else {
                require APP . 'View/register/verifyFail.php';
            }
            $token->deleteExpiredFromDatabase($dao);
            unset($sqlite);
        } catch (PDOException $ex) {
            unset($sqlite);
            die(header('location: ' . URL . 'error/databaseError'));
        }

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
