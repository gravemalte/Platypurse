<?php


namespace Controller;


use DateTime;
use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Hydro\Helper\FakeMailer;
use Model\DAO\ResetTokenDAO;
use Model\DAO\UserDAO;
use Model\ResetTokenModel;
use Model\UserModel;
use PDOException;

class ResetPasswordController extends BaseController
{

    public function index(){
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/reset-password/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/reset-password/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function resetPasswordMail() {
        if (!isset($_GET['mail'])) {
            http_response_code(400);
            header('location: ' . URL . 'error/badRequest');
            return;
        }

        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new UserDAO($con);
        try {
            $user = UserModel::getFromDatabaseByMail($dao, $_GET['mail']);

            $mail = FakeMailer::sendResetPasswordMail($user);
            header('location: ' . URL . 'resetPassword/instructionsSent?id=' . $mail->getId());
        }
        catch (PDOException $e) {
            header('location: ' . URL . 'resetPassword/instructionsSent?id=' . 0);
        }
        unset($sqlite);
    }

    public static function instructionsSent() {
        require APP . 'View/shared/header.php';
        require APP . 'View/reset-password/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/reset-password/instructionsSent.php';
        require APP . 'View/shared/footer.php';
    }

    public static function resetPassword() {
        if (!isset($_GET['token'])) {
            http_response_code(404);
            header('location: ' . URL . 'error/notFound');
            return;
        }

        require APP . 'View/shared/header.php';
        require APP . 'View/reset-password/header.php';
        require APP . 'View/shared/nav.php';

        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $sqlite->openTransaction();
            $resetTokenDao = new ResetTokenDAO($con);
            $tokenModel = ResetTokenModel::getFromDatabase($resetTokenDao, $_GET['token']);

            $expirationDate = new DateTime($tokenModel->getExpirationDate());
            $nowDate = new DateTime("now");
            if (!$tokenModel || $expirationDate >= $nowDate) {
                $newPassword = bin2hex(random_bytes(5));
                $user = $tokenModel->getUser();
                $user->setPassword($newPassword);

                $userDao = new UserDAO($con);
                $user->updateInDatabase($userDao);

                $tokenModel->deleteForUserFromDatabase($resetTokenDao, $user->getId());
                $tokenModel->deleteExpiredFromDatabase($resetTokenDao);

                $sqlite->closeTransaction(true);
                require APP . 'View/reset-password/newPassword.php';
            }
            else {
                require APP . 'View/reset-password/invalidToken.php';
            }
        } catch (PDOException $ex) {
            $sqlite->closeTransaction(false);
            header('location: ' . URL . 'error/databaseError');
        }

        unset($sqlite);
        require APP . 'View/shared/footer.php';
    }
}