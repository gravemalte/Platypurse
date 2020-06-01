<?php

namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Helper\DataSerialize;
use Model\UserModel;

class LoginController extends BaseController
{

    public function index()
    {
        if(isset($_SESSION['user-ID'])){
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
        if(!(isset($_POST["user-email"]) && isset($_POST["user-passwd"]))){
            $_SESSION['user-login-error'] = true;
            header('location: '. URL . 'login');
            exit();
        }
        $userSentMail = strtolower($_POST["user-email"]);
        $userSentPasswd = strtolower($_POST["user-passwd"]);

        $userData = UserModel::getData();
        if($userData == false){
            $_SESSION['user-login-error'] = true;
            header('location: ' . URL . 'login');
            exit();
        }

        $unserializeData = DataSerialize::unserializeData($userData);

        foreach ($unserializeData as $user) {
            $userID = $user->getUserID();
            $userDisplayName = $user->getDisplayName();
            $userMail = $user->getEmail();
            $userPasswd = $user->getPassword();
            if ($this->checkCredentials($userSentMail, $userMail,
                $userSentPasswd, $userPasswd)) {
                $_SESSION['user-ID'] = $userID;
                $_SESSION['user-displayName']= $userDisplayName;
                $_SESSION['user-email'] = $userMail;
                $_SESSION['user-passwd'] = $userPasswd;
                header('location: ' . URL);
                exit();
            }
        }
        $_SESSION['user-login-error'] = true;
        header('location: ' . URL . 'login');
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