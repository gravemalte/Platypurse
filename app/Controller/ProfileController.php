<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Model\OfferGridModel;
use Model\OfferModel;
use Model\UserModel;

class ProfileController extends BaseController
{
    public function index(){

        if(!(isset($_SESSION['currentUser']))) {
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

    public function getOffersForUser($id) {
        //SELECT * FROM offer WHERE u_id = 2
        $whereClause = COLUMNS_OFFER["u_id"]. " = ?";
        return OfferGridModel::getFromDatabase($whereClause, array($id));
    }

    public function getSavedOffers($id) {
        // SELECT * FROM saved_offers as so INNER JOIN offer o on so.o_id = o.o_id WHERE so.u_id = 2
        $fromClause = "saved_offers as so INNER JOIN " .TABLE_OFFER. " o on so.o_id = o.o_id";
        return OfferModel::getFromDatabase();
    }

}