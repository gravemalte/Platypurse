<main class="main-page login-page">
    <div class="login-area">
        <div class="form-container card">
            <div class="title-container">
                <p>Anmelden</p>
            </div>
            <form action="login/login" method="post" class="login-form">
                <p class="error-text">
                    <?php if(isset($_SESSION['user-login-error'])) : ?>
                        Die Kombination aus Email und Passwort sind ungültig.
                    <?php endif; ?>
                </p>
                <div class="form-email-container">
                    <?php if(isset($_SESSION['user-login-error'])) : ?>
                    <div class="show-error"></div>
                    <?php endif; ?>
                    <label for="user-email">Email Adresse</label>
                    <input type="email" id="user-email" name="user-email" placeholder="Email Adresse" autofocus required>
                </div>
                <div class="form-passwd-container">
                    <?php if(isset($_SESSION['user-login-error'])) : ?>
                        <div class="show-error"></div>
                    <?php endif; ?>
                    <label for="show-passwd" hidden>Passwort anzeigen</label>
                    <input type="checkbox" id="show-passwd" data-toggle-password="user-passwd" hidden>
                    <label for="show-passwd" class="fas fa-eye no-js-hide"></label>
                    <label for="show-passwd" class="fas fa-eye-slash no-js-hide"></label>
                    <label for="user-passwd">Passwort</label>
                    <input type="password" id="user-passwd" name="user-passwd" placeholder="Passwort" required>
                </div>
                <div class="form-misc-container">
                    <div class="form-remember-me-container">
                        <label for="remember-me">Anmeldung merken</label>
                        <input type="checkbox" id="remember-me" name="user-remember-me">
                        <label for="remember-me" class="fas fa-square no-js-hide"></label>
                        <label for="remember-me" class="fas fa-check-square no-js-hide"></label>
                    </div>
                    <div class="form-forgot-container">
                        <a href="">Passwort vergessen?</a>
                    </div>
                </div>
                <div class="form-submit-container">
                    <label for="submit" hidden>Anmelden</label>
                    <button id="submit" type="submit">
                        <span>Anmelden</span>
                        <span class="fas fa-sign-in-alt"></span>
                    </button>
                </div>
                <div class="form-no-account-container">
                    <p>Kein Konto?</p>
                    <a href="register">Erstelle eins!</a>
                </div>
            </form>
        </div>
    </div>
</main>