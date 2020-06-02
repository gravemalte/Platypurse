<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;

class ProfileController extends BaseController
{
    public function index($userID = 0){

        if(!(isset($_SESSION['user-ID']))){
            header('location: ' . URL . 'login');
        }


        if(isset($userID) && $userID != 0){
            $this->searchUser($userID);
        }
        require APP . 'View/shared/header.php';
        require APP . 'View/profile/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/profile/index.php';
        require APP . 'View/shared/footer.php';
    }

    // TODO: Profil edit functionality
    public function edit(){
        header('location: ' . URL . 'profileedit');
    }


    private function searchUser($userID){

    }

}