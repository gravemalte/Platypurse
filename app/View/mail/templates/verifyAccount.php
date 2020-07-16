<?php
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Verifiziere Konto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="platypus, trade">
    <meta name="author" content="Malte Grave, Tim Hesse, Marvin Kuhlmann">

    <style>
        body {
            background-color: #DDD;
            padding: 2em;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        p,
        span,
        h1, h2, h3, h4, h5, h6,
        i,
        a,
        input,
        textarea,
        select,
        label,
        li {
            font-family: sans-serif;
        }

        .card {
            background-color: white;
            border-radius: 30px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
            max-width: 700px;
        }

        .header-container {
            background-color: #222;
            display: flex;
            flex-direction: column;
            color: #FFF;
            align-items: center;
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
            object-fit: cover;
        }
        .header-container img {
            filter: invert(1);
            margin: 10px;
            height: 70px;
        }
        .header-container h1 {
            margin-top: 0;
            text-align: center;
        }

        .text-container {
            color: #333;
            padding: 3em 3em 1em;
        }
        .text-container h2,
        .text-container p {
            color: inherit;
            margin: 0;
        }

        .under-button-container,
        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .button-container a {
            background-color: #0074FF;
            color: white;
            border-radius: 5px;
            padding: 1em;
            margin: 1em;
            text-decoration: none;
        }

        .under-button-container p {
            font-size: 0.8em;
            color: #555;
            padding: 1em 3em;
        }
        .under-button-container a {
            white-space: pre;
        }

        .footer {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .footer * {
            color: #555;
            text-align: center;
            font-size: 0.7em;
            margin: 0.5em 0 0;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="header-container">
        <img src="../assets/logo/svg/logo_1tone.svg" alt="">
        <h1>Willkommen zu Platypurse!</h1>
    </div>
    <div class="text-container">
        <h2>Hey INSERT NAME HERE</h2>
        <p>
            Mega cool, dass du dir ein Konto bei uns erstellt hast.
            Jetzt musst du dich nur noch verifizieren damit wir wissen, dass du auch Zugriff auf deine Mail hast.
            <br>
            Klick einfach auf den Button.
        </p>
    </div>
    <div class="button-container">
        <a href="../register/verify?token=TOKENHERE">
            Verifiziere dein Konto!
        </a>
    </div>
    <div class="under-button-container">
        <p>
            Wenn der Button nicht funktioniert, geh einfach auf diese Webseite
            <a href="../register/verify?token=TOKENHERE">platypurse.com/register/<wbr>verify?token=TOKENHERE</a>.
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