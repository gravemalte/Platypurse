<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Helper\DataSerialize;
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
        if($this->checkExistingUser($user) != true){
            $user->registerUser($user);
            header('location: ' . URL . 'login');
            exit();
        }
        header('location: ' . URL . 'register');
    }

    private function checkExistingUser($newUser){
        $userModel = UserModel::getData();
        $unserializeUserModel = DataSerialize::unserializeData($userModel);
        foreach ($unserializeUserModel as $user){
            if ($user->getEmail() == $newUser->getEmail()){
                $_SESSION['register-error-email'] = true;
                return true;
            }
        }
        return false;
    }

}
