<main class="main-page login-page">
    <div class="login-area">
        <div class="login-form-container card">
            <div class="title-container">
                <p>Anmelden</p>
            </div>
            <form action="login/login" method="post" class="login-form">
                <div class="login-form-email-container">
                    <label for="user-email">Email Adresse</label>
                    <input type="email" id="user-email" name="user-email" placeholder="Email Adresse">

                </div>
                <div class="login-form-passwd-container">
                    <label for="show-passwd" hidden>Passwort anzeigen</label>
                    <input type="checkbox" id="show-passwd" hidden>
                    <label for="show-passwd" class="fas fa-eye"></label>
                    <label for="show-passwd" class="fas fa-eye-slash" hidden></label>
                    <label for="user-passwd">Passwort</label>
                    <input type="text" id="user-passwd" name="user-passwd" placeholder="Passwort">
                </div>
                <div class="login-form-misc-container">
                    <div class="login-form-remember-me-container">
                        <label for="remember-me">Anmeldung merken</label>
                        <input type="checkbox" id="remember-me" name="remember-me">
                        <label for="remember-me" class="fas fa-square"></label>
                        <label for="remember-me" class="fas fa-check-square"></label>
                    </div>
                    <div class="login-form-forgot-container">
                        <a href="">Passwort vergessen?</a>
                    </div>
                </div>
                <div class="login-form-submit-container">
                    <label for="submit" hidden>Anmelden</label>
                    <button id="submit" type="submit">
                        <span>Anmelden</span>
                        <span class="fas fa-sign-in-alt"></span>
                    </button>
                </div>
                <div class="login-form-no-account-container">
                    <p>Kein Account?</p>
                    <a href="register">Erstelle ein Konto!</a>
                </div>
            </form>
        </div>
    </div>
</main>