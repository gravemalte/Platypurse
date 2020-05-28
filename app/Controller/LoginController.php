<?php

namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Helper\DataSerialize;
use Model\UserModel;

class LoginController extends BaseController
{

    public function index()
    {
        // load views
        require APP . 'View/shared/header.php';
        require APP . 'View/login/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/login/index.php';
        require APP . 'View/shared/footer.php';
    }

    public function login()
    {
        $userSentMail = $_POST["user-email"];
        $userSentPasswd = $_POST["user-passwd"];
        $userData = UserModel::getData();
        $unserializeData = DataSerialize::unserializeData($userData);

        foreach ($unserializeData as $user) {
            $userMail = $user->getEmail();
            $userPasswd = $user->getPassword();
            if ($this->checkCredentials($userSentMail, $userMail,
                $userSentPasswd, $userPasswd)) {
                $_SESSION['user-email'] = $userMail;
                $_SESSION['user-passwd'] = $userPasswd;
                header('location: ' . URL);
                exit();
            }
        }
        header('location: ' . URL . 'error');
    }

    private function checkCredentials($userEmailInput, $dbEmailInout,
                                      $userPasswdInput, $dbPasswdInput)
    {
        if ($userEmailInput == $dbEmailInout && $userPasswdInput == $dbPasswdInput) {
            return true;
        } else {
            return false;
        }

    }

    private function checkSession()
    {
    }

    public function logout(){
        session_destroy();
        header('location: ' . URL);
    }


}