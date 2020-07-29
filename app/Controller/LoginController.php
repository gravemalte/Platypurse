<?php
namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\UserDAO;
use Model\UserModel;

class LoginController extends BaseController
{

    public function index()
    {
        if (isset($_SESSION['currentUser'])) {
            header('location: ' . URL . 'error/alreadyLoggedIn');
            exit();
        }
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/login/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/login/index.php';
        require APP . 'View/shared/footer.php';
        session_destroy();
    }

    /**
     * Try to login with the form data
     */
    public function login()
    {
        if (!(isset($_POST['user-email']) && isset($_POST['user-passwd']))) {
            $_SESSION['user-login-error'] = true;
            header('location: ' . URL . 'login');
            exit();
        }

        if(isset($_POST['user-remember-me'])){
            session_destroy();
            session_set_cookie_params(10800);
            session_start();
        }


        $userSentMail = strtolower($_POST['user-email']);
        $userSentPasswd = $_POST['user-passwd'];


        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $user = UserModel::getFromDatabaseByMail(new UserDAO($con), $userSentMail);
        unset($sqlite);
        if ($user) {
            if (password_verify($userSentPasswd, $user->getPassword())) {
                if (!$user->isVerified() ) {
                    $_SESSION['user-verify-error'] = true;
                    header('location: ' . URL . 'login');
                    exit();
                }
                $_SESSION['currentUser'] = $user;
                header('location: ' . URL);
                exit();
            }
        }
        $_SESSION['user-login-error'] = true;
        header('location: ' . URL . 'login');
    }

    /**
     * Logout the current user
     */
    public function logout()
    {
        session_destroy();
        header('location: ' . URL);
    }
}
