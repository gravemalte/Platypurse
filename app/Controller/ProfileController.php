<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Model\UserModel;

class ProfileController extends BaseController
{
    public function index(){

        if(!(isset($_SESSION['user-ID']))) {
            header('location: ' . URL . 'login');
        }

        if(!(isset($_GET['id']))){
            header('location: ' . URL . 'error');
        }


        if(isset($_GET['id'] )){
            $user = self::getUser($_GET['id']);
            if($user == false){
                header('location: ' . URL . 'error');
            }
        }

        require APP . 'View/shared/header.php';
        require APP . 'View/profile/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/profile/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getUser($id){
       return UserModel::searchUser($id);
    }

}