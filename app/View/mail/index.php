<?php
use \Model\DAO\MailDAO;
use \Hydro\Base\Database\Driver\SQLite;
use \Model\MailModel;
use \Controller\MailController;

$dao = new MailDAO(SQLite::connectToSQLite());
$mail = MailModel::getFromDatabase($dao, $_GET['id']);

if (!$mail->exists()) {
    header('location: ' . URL . 'error');
    exit();
}

$id = $mail->getId();
$name = $mail->getReceiverName();
$mail_address = $mail->getReceiverMail();
?>

<body>
<div class="mail-meta-container">
    <p>Diese Mail ging an:</p>
    <p class="mail-meta-displayname"><?= $name ?></p>
    <a class="mail-meta-mail" href="mailto:<?= $mail_address ?>"><?= $mail_address ?></a>
</div>
<div class="mail-preview-container">
    <iframe src="mail/getMailContent?id=<?= $id ?>" frameborder="0" class="mail-preview"></iframe>
</div>
</body>