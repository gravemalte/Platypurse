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
        <h1>Wolltest du dich registrieren?</h1>
    </div>
    <div class="text-container">
        <h2>Hey <?= $user->getDisplayName() ?></h2>
        <p>
            Es sieht so aus, dass sich jemand mit deiner Email Adresse registrieren wollte.
            Wenn das nicht du warst, dann kann du diese Mail ignorieren und dich darüber freuen, dass unsere Seite so sicher ist.
            :D
            <br>
            Wenn du dein Passwort vergessen haben solltest, kannst du es einfach auf der Login Seite zurücksetzen.
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