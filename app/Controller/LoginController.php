<?php

namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;

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
        $userSentPasswd = $_POST['user-passwd'];

        $result = $this->checkCredentials($userSentMail, $userSentPasswd);


        if($result[0] == true){
            $_SESSION['user-ID'] = $result["userID"];
            $_SESSION['user-display-name']= $result["display_name"];
            $_SESSION['user-email'] = $result["mail"];
            header('location: ' . URL);
            exit();
        }
        $_SESSION['user-login-error'] = true;
        header('location: ' . URL . 'login');
    }

    private function checkCredentials($userEmail, $userPasswd){
        $sql_query = "SELECT * FROM user WHERE mail = '$userEmail' AND password = '$userPasswd'";
        $con = SQLite::connectToSQLite();
        $query = $con->prepare($sql_query);
        $query->execute();
        $obj = $query->fetchObject();
        if($obj == null){
            return false;
        }else{
            return array(true, "userID"=>$obj->ug_id, "display_name"=>$obj->display_name,
                "mail"=>$obj->mail);
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
