<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Model\UserModel;
use Hydro\Helper\Date;


class RegisterController extends BaseController {

    public function index(){
        require APP . 'View/shared/header.php';
        require APP . 'View/register/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/register/index.php';
        require APP . 'View/shared/footer.php';
        session_destroy();
    }

    public function register(){
        if(!(isset($_POST["user-email"]) || isset($_POST["user-passwd"])
        || isset($_POST['user-display-name']) || isset($_POST['user-passwd2']))){
            $_SESSION['register-error'] = true;
            header('location:' . URL . 'register');
        }

        $userInputDisplayName = $_POST['user-display-name'];
        $userInputMail =strtolower($_POST['user-email']);
        $userInputPassswd = $_POST['user-passwd'];
        $userInputPassswd2 = $_POST['user-passwd2'];

        if($userInputPassswd != $userInputPassswd2){
            $_SESSION['register-error-password'] = true;
            header('location:' . URL . 'register');
            exit();
        }

        $user = new UserModel(hexdec(uniqid()),
            $userInputDisplayName,
            $userInputMail,
            password_hash($userInputPassswd, PASSWORD_DEFAULT),
            2,
            0,
            Date::now(),
            0);

        $check = $user->registerUser();
        if($check){
            unset($user);
            header('location: '. URL . 'login');
        }else{
            unset($user);
            $_SESSION['register-error'] = true;
            header('location: '. URL . 'register');
        }
    }


}
