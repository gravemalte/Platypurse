<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Verifiziere Konto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="platypus, trade">
    <meta name="author" content="Malte Grave, Tim Hesse, Marvin Kuhlmann">

    <?php require APP . 'View/mail/templates/styles.php' ?>
</head>
<body>
<div class="card">
    <div class="header-container">
        <img src="../assets/logo/svg/logo_1tone.svg" alt="">
        <h1>Willkommen zu Platypurse!</h1>
    </div>
    <div class="text-container">
        <h2>Hey <?= $user->getDisplayName() ?></h2>
        <p>
            Mega cool, dass du dir ein Konto bei uns erstellt hast.
            Jetzt musst du dich nur noch verifizieren damit wir wissen, dass du auch Zugriff auf deine Mail hast.
            <br>
            Klick einfach auf den Button.
        </p>
    </div>
    <div class="button-container">
        <a href="../register/verify?token=<?= $token->getToken() ?>" target="_blank">
            Verifiziere dein Konto!
        </a>
    </div>
    <div class="under-button-container">
        <p>
            Wenn der Button nicht funktioniert, geh einfach auf diese Webseite
            <a href="<?= URL ?> /register/verify?token=<?= $token->getToken() ?>" target="_blank">platypurse.com/register/<wbr>verify?token=<?= $token->getToken() ?></a>.
        </p>
    </div>
</div>
<div class="footer">
    <h4>Platypurse GbR</h4>
    <p>
        Schnabeltierstraße 5, 26129 Oldenburg
    </p>
</div>
</body>
</html>