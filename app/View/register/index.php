<?php

$show_error = false;

?>
<main class="main-page register-page">
    <div class="register-area">
        <div class="form-container card">
            <div class="title-container">
                <p>Registrieren</p>
            </div>
            <div class="description-container">
                <p>Erstelle ein Konto für Platypurse</p>
            </div>
            <form action="register/register" method="post" class="register-form">
                <p class="error-text">
                    <?php if(isset($_SESSION['register-error'])) : ?>
                        Der angegebene Nutzername existiert bereits, wähle bitte einen neuen.
                    <?php endif; ?>

                    <?php if(isset($_SESSION['register-error-password'])) : ?>
                        Die angegebenen Passwörter stimmen nicht überein.
                    <?php endif; ?>

                    <?php if(isset($_SESSION['register-error-agb'])) : ?>
                        Bitte die AGB Akzeptieren.
                    <?php endif; ?>

                </p>
                <div class="form-user-display-name-container">
                    <?php if(isset($_SESSION['register-error'])) : ?>
                        <div class="show-error"></div>
                    <?php endif; ?>
                    <label for="user-display-name">Anzeigename</label>

                    <?php if(isset($_SESSION['register-error-agb']) || isset($_SESSION['register-error-password']) || isset($_SESSION['register-error'])) : ?>
                        <input type="text" id="user-display-name" name="user-display-name" value="<?= $_SESSION['register-inputName'] ?>" required autofocus>
                    <?php else: ?>
                        <input type="text" id="user-display-name" name="user-display-name" placeholder="Anzeigename" required autofocus>
                    <?php endif; ?>
                </div>
                <div class="form-email-container">
                    <label for="user-email">Email Adresse</label>
                    <?php if(isset($_SESSION['register-error-agb']) || isset($_SESSION['register-error-password']) || isset($_SESSION['register-error'])): ?>
                        <input type="text" id="user-email" name="user-email" value="<?= $_SESSION['register-inputMail'] ?>" required autofocus>
                    <?php else: ?>
                        <input type="email" id="user-email" name="user-email" placeholder="Email Adresse" required>
                    <?php endif; ?>
                </div>
                <div class="form-passwd-container">
                    <?php if(isset($_SESSION['register-error-password'])) : ?>
                        <div class="show-error"></div>
                    <?php endif; ?>
                    <label for="show-passwd-1" hidden>Passwort anzeigen</label>
                    <input type="checkbox" id="show-passwd-1" data-toggle-password="user-passwd-1" hidden>
                    <label for="show-passwd-1" class="fas fa-eye no-js-hide"></label>
                    <label for="show-passwd-1" class="fas fa-eye-slash no-js-hide"></label>
                    <label for="user-passwd-1">Passwort</label>
                    <input type="password" id="user-passwd-1" name="user-passwd" placeholder="Passwort" required>
                </div>
                <div class="form-passwd-container">
                    <?php if(isset($_SESSION['register-error-password'])) : ?>
                        <div class="show-error"></div>
                    <?php endif; ?>
                    <label for="show-passwd-2" hidden>Passwort anzeigen</label>
                    <input type="checkbox" id="show-passwd-2" data-toggle-password="user-passwd-2" hidden>
                    <label for="show-passwd-2" class="fas fa-eye no-js-hide"></label>
                    <label for="show-passwd-2" class="fas fa-eye-slash no-js-hide"></label>
                    <label for="user-passwd-2">Passwort wiederholen</label>
                    <input type="password" id="user-passwd-2" name="user-passwd2" placeholder="Passwort wiederholen" required>
                </div>

                <div class="form-misc-container">
                    <div class="form-agb-confirm-container">

                        <label for="agb-confirm"><a href="./termsOfUse">Nutzungsbedingungen</a> akzeptieren</label>
                        <input type="checkbox" id="agb-confirm" name="agb-confirm">
                        <label for="agb-confirm" class="fas fa-square no-js-hide"></label>
                        <label for="agb-confirm" class="fas fa-check-square no-js-hide"></label>
                    </div>
                </div>
                <div class="form-submit-container">
                    <label for="submit" hidden>Registrieren</label>
                    <button id="submit" type="submit">
                        <span>Registrieren</span>
                        <span class="fas fa-truck"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>