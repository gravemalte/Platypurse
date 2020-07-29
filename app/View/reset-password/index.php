<main class="main-page">
    <div class="main-area reset-password-area card" style="padding: 1em;">
        <h1 class="title">Passwort vergessen?</h1>
        <p class="description">
            Hey, hast du dein Passwort vergessen?
            <br>
            Kein Problem, gib einfach deine Mail Adresse hier ein und wir schicken dir eine Mail mit der du dir
            dann ein neues Passwort holen kannst.
        </p>
        <form action="resetPassword/resetPasswordMail" class="reset-mail-form">
            <label for="reset-mail-input"></label>
            <input id="reset-mail-input" type="email" placeholder="Deine Mail Adresse" name="mail">
            <button>
                Neues Passwort anfordern
            </button>
        </form>
    </div>
</main>