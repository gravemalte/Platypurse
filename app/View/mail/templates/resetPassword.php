<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Passwort vergessen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="platypus, trade">
    <meta name="author" content="Malte Grave, Tim Hesse, Marvin Kuhlmann">

    <?php require APP . 'View/mail/templates/styles.php' ?>
</head>
<body>
<div class="card">
    <div class="header-container">
        <img src="../assets/logo/svg/logo_1tone.svg" alt="">
        <h1>Passwort vergessen?</h1>
    </div>
    <div class="text-container">
        <h2>Hey <?= $user->getDisplayName() ?></h2>
        <p>
            Hast du dein Passwort vergessen?
            <br>
            Wenn ja, kein Problem. Klicke einfach hier auf den Button.
            <br>
            Wenn nein, dann keine Sorge. Ignoriere einfach diese Mail.
        </p>
    </div>
    <div class="button-container">
        <a href="<?= URL ?>resetPassword/resetPassword?token=<?= $token->getToken() ?>" target="_blank">
            Neues Passwort anfordern!
        </a>
    </div>
    <div class="under-button-container">
        <p>
            Wenn der Button nicht funktioniert, geh einfach auf diese Webseite
            <a href="<?= URL ?>resetPassword/resetPassword?token=<?= $token->getToken() ?>" target="_blank">platypurse.com/register/<wbr>verify?token=<?= $token->getToken() ?></a>.
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