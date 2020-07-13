<?php


namespace Controller;


class MailController
{

    public function index() {
        // load views
        require APP . 'View/mail/header.php';
        require APP . 'View/mail/index.php';
    }
}