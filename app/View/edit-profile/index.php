<?php

use Controller\EditProfileController;

$user = EditProfileController::getUser();

?>

<main class="main-page edit-profile-page">
    <div class="edit-profile-area">
        <div class="edit-profile-container card">
            <form action="editProfile/update" method="post">
                <input type="hidden" name="id" value="<?= $user->getId() ?>">
                <div class="avatar-upload-container">
                    <input type="file" accept="image/*" id="image-upload" alt="user avatar upload" hidden>
                    <label for="image-upload">
                        <img src="assets/nav/user-circle-solid.svg" alt="user avatar">
                        <span>Wähle neuen Avatar</span>
                    </label>
                </div>
                <div class="text-inputs-container">
                    <div class="display-name-container">
                        <p>Anzeigename anpassen</p>
                        <input
                                type="text"
                                name="display-name"
                                id="display-name-input"
                                placeholder="<?= $user->getDisplayName() ?>"
                        >
                        <label for="display-name-input" hidden>Anzeigename anpassen</label>
                    </div>
                    <div class="mail-container">
                        <p>Email anpassen</p>
                        <input
                                type="text"
                                name="email"
                                id="email-input"
                                placeholder="<?= $user->getMail() ?>"
                        >
                        <label for="email-input" hidden>Email anpassen</label>
                    </div>
                    <div>
                        <p>Passwort ändern</p>
                        <input
                                type="password"
                                name="password"
                                id="password-input"
                                placeholder="Passwort"
                        >
                    </div>
                </div>
                <div class="submit-container">
                    <button type="submit" title="Profil anpassen">
                        <span class="fas fa-clipboard-check"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>