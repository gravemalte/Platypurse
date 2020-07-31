<?php

use Controller\MailController;

$mail = MailController::getMail($_GET['id']);

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
    <iframe src="mail/getMailContent?id=<?= $id ?>" style="border: none" class="mail-preview"></iframe>
</div>
</body>