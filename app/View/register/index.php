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
                <?php if($show_error) : ?>
                    <div class="error-text-container">
                        <p id="error-text">Die angegebenen Daten sind ungültig.</p>
                    </div>
                <?php endif; ?>
                <div class="form-user-display-name-container">
                    <?php if($show_error) : ?>
                        <div class="show-error"></div>
                    <?php endif; ?>
                    <label for="user-display-name">Anzeigename</label>
                    <input type="text" id="user-display-name" name="user-display-name" placeholder="Anzeigename" required autofocus>
                </div>
                <div class="form-email-container">
                    <?php if($show_error) : ?>
                        <div class="show-error"></div>
                    <?php endif; ?>
                    <label for="user-email">Email Adresse</label>
                    <input type="email" id="user-email" name="user-email" placeholder="Email Adresse" required>
                </div>
                <div class="form-passwd-container">
                    <?php if($show_error) : ?>
                        <div class="show-error"></div>
                    <?php endif; ?>
                    <label for="show-passwd" hidden>Passwort anzeigen</label>
                    <input type="checkbox" id="show-passwd" hidden>
                    <label for="show-passwd" class="fas fa-eye"></label>
                    <label for="show-passwd" class="fas fa-eye-slash"></label>
                    <label for="user-passwd">Passwort</label>
                    <input type="text" id="user-passwd" name="user-passwd" placeholder="Passwort" required>
                </div>
                <div class="form-passwd-container">
                    <?php if($show_error) : ?>
                        <div class="show-error"></div>
                    <?php endif; ?>
                    <label for="show-passwd" hidden>Passwort anzeigen</label>
                    <input type="checkbox" id="show-passwd" hidden>
                    <label for="show-passwd" class="fas fa-eye"></label>
                    <label for="show-passwd" class="fas fa-eye-slash"></label>
                    <label for="user-passwd">Passwort wiederholen</label>
                    <input type="text" id="user-passwd" name="user-passwd" placeholder="Passwort wiederholen" required>
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