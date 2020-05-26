<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;

class ChatController extends BaseController
{
    public function index(){
        require APP . 'View/shared/header.php';
        require APP . 'View/chat/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/chat/index.php';
        require APP . 'View/shared/footer.php';
    }
}