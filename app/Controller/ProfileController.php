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

        require APP . 'View/shared/header.php';
        require APP . 'View/profile/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/profile/index.php';
        require APP . 'View/shared/footer.php';
    }

    public function search(){
        $searchID = $_GET['id'];
        $user = UserModel::searchUser($searchID);
        if($user[0]){
            $_SESSION['searched-user'] = true;
            $_SESSION['searched-user-id'] = $user['userID'];
            $_SESSION['searched-user-display-name'] = $user['display_name'];
            header('location: ' . URL . 'profile');
        }else{
            header('location: ' . URL);
        }

    }

}