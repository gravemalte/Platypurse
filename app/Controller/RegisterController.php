<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Helper\DataSerialize;
use Model\UserModel;


class RegisterController extends BaseController {

    public function index(){
        require APP . 'View/shared/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/register/index.php';
    }

    public function register(){
        $userInputMail = $_POST["user-email"];
        $userInputPassswd = $_POST["user-passwd"];
        $user = new UserModel($userInputMail, $userInputPassswd);
        if($this->checkExistingUser($user) != true){
            $user->registerUser($user);
            header('location: ' . URL);
            exit();
        }else {
            header('location: ' . URL . 'error');
        }
    }

    private function checkExistingUser($newUser){
        $userModel = UserModel::getData();
        $unserializeUserModel = DataSerialize::unserializeData($userModel);
        foreach ($unserializeUserModel as $user){
            if ($user->getEmail() == $newUser->getEmail()){
                return true;
            }
        }
        return false;
    }

}