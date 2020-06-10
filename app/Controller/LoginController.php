<?php

namespace Controller;


use http\Client\Curl\User;
use Hydro\Base\Controller\BaseController;
use Model\UserModel;

class LoginController extends BaseController
{

    public function index()
    {
        if (isset($_SESSION['currentUser'])) {
            header('location: ' . URL . 'error');
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

    public function login()
    {
        if (!(isset($_POST['user-email']) && isset($_POST['user-passwd']))) {
            $_SESSION['user-login-error'] = true;
            header('location: ' . URL . 'login');
            exit();
        }


        $userSentMail = strtolower($_POST['user-email']);
        $userSentPasswd = $_POST['user-passwd'];

        $result = UserModel::searchUserEmail($userSentMail);
        if (!empty($result)):
            foreach ($result as $row):
                $user = new UserModel($row[COLUMNS_USER["u_id"]],
                    $row[COLUMNS_USER["display_name"]],
                    $row[COLUMNS_USER["mail"]],
                    $row[COLUMNS_USER["password"]],
                    $row[COLUMNS_USER["ug_id"]],
                    $row[COLUMNS_USER["rating"]],
                    $row[COLUMNS_USER["created_at"]],
                    $row[COLUMNS_USER["display_name"]]);
                if (password_verify($userSentPasswd, $user->getPassword())) {
                    $_SESSION['currentUser'] = $user;
                    header('location: ' . URL);
                    exit();
                }
            endforeach;
        endif;
        $_SESSION['user-login-error'] = true;
        header('location: ' . URL . 'login');
    }

    private function checkSession()
    {
    }

    public function logout()
    {
        session_destroy();
        header('location: ' . URL);
    }


}
