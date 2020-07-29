<?php


namespace Hydro\Helper;

use Model\MailModel;
use Model\RegisterTokenModel;
use Model\ResetTokenModel;

class FakeMailer {

    const MAIL_TEMPLATE_PATH = APP
    . 'View'
    . DIRECTORY_SEPARATOR
    . 'mail'
    . DIRECTORY_SEPARATOR
    . 'templates'
    . DIRECTORY_SEPARATOR;

    private static function sendMail($mailType, $user, $variables = array()) {
        ob_start();
        extract($variables);
        switch ($mailType) {
            case "verify":
                include(self::MAIL_TEMPLATE_PATH . 'verifyAccount.php');
                break;
            case "duplicateMail":
                include(self::MAIL_TEMPLATE_PATH . 'duplicateMail.php');
                break;
            case "resetPassword":
                include(self::MAIL_TEMPLATE_PATH . 'resetPassword.php');
                break;
        }
        $php_to_html = ob_get_clean();
        $html_encoded = htmlentities($php_to_html);

        return MailModel::initMail($user, $html_encoded);
    }

    public static function sendVerifyMail($userModel) {
        return self::sendMail("verify", $userModel, array(
            'token' => RegisterTokenModel::generate($userModel)
        ));
    }

    public static function sendDuplicateMail($userModel) {
        return self::sendMail("duplicateMail", $userModel);
    }

    public static function sendResetPasswordMail($userModel) {
        return self::sendMail("resetPassword", $userModel, array(
            'token' => ResetTokenModel::generate($userModel)
        ));
    }
}