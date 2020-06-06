<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Model\UserModel;


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
        if(!(isset($_POST["user-email"]) && isset($_POST["user-passwd"])
        && isset($_POST['user-display-name']))){
            $_SESSION['register-error'] = true;
            header('location:' . URL . 'register');
        }

        // TODO: Needs more love strtolower can be inlined
        $userInputDisplayName = $_POST['user-display-name'];
        $userInputMail = $_POST['user-email'];
        $userInputPassswd = $_POST['user-passwd'];
        $userInputMail = strtolower($userInputMail);

        $user = new UserModel($userInputDisplayName, $userInputMail, $userInputPassswd);

        $check = $user->registerUser();
        if($check){
            unset($user);
            header('location: '. URL . 'login');
        }else{
            unset($user);
            header('location: '. URL . 'register');
        }
    }


}
