<?php

namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\DAOUser;
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
        $userInputMail = strtolower($_POST['user-email']);
        $userInputPassswd = $_POST['user-passwd'];
        $userInputPassswd2 = $_POST['user-passwd2'];

        if($userInputPassswd != $userInputPassswd2){
            $_SESSION['register-error-password'] = true;
            header('location:' . URL . 'register');
            exit();
        }

        if(!isset($_POST['agb-confirm'])){
            $_SESSION['register-error-agb'] = true;
            header('location:' . URL . 'register');
            exit();
        }

        $defaultImagePath = "assets/nav/user-circle-solid.svg";
        $mime = "image/" .pathinfo($defaultImagePath)['extension']. '+xml';
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
            0);

        $con = SQLITE::connectToSQLite();
        $userDao = new DAOUser($con);
        $check = $userModel->insertIntoDatabase($userDao);

        if($check){
            unset($userModel);
            header('location: '. URL . 'login');
        }else{
            unset($userModel);
            $_SESSION['register-error'] = true;
            header('location: '. URL . 'register');
        }
    }


}
