<?php

use Controller\ProfileController;

$displayUser = ProfileController::getDisplayUser();

$userItself = false;
$viewHasAdmin = false;
$loggedIn = false;
if (isset($_SESSION['currentUser'])) {
    $currentUser = $_SESSION['currentUser'];
    if ($currentUser->getId() == $displayUser->getId()) $userItself = true;
    if ($currentUser->isAdmin()) $viewHasAdmin = true;
    $loggedIn = true;
}

$savedOffers = ProfileController::getSavedOffers();
$offersByUser = ProfileController::getOffersFromUser();

?>

<main class="main-page profile-page">
    <div class="profile-area">
        <div class="profile-container card">
            <div class="profile-image">
                <img src="assets/nav/user-circle-solid.svg" alt="profile image">
            </div>
            <div class="profile-display-name">
                <span><?= $displayUser->getDisplayName() ?></span>
                <?php if ($displayUser->isDisabled()): ?>

                <span><strong>[Account deaktiviert]</strong></span>

                <?php endif; ?>
            </div>
            <div class="user-rating">
                <span class="fas fa-star" id="user-rating-5"></span>
                <span class="fas fa-star" id="user-rating-4"></span>
                <span class="fas fa-star" id="user-rating-3"></span>
                <span class="fas fa-star" id="user-rating-2"></span>
                <span class="fas fa-star" id="user-rating-1"></span>
            </div>
            <div class="profile-button-container">
                <?php if (!$userItself): ?>
                <a href="chat?u=<?= $displayUser->getId() ?>">
                    <button class="send-message-button button">
                        <span>Nachricht schreiben</span>
                    </button>
                </a>
                <?php endif; ?>
                <?php if ($userItself || $viewHasAdmin): ?>
                <a href="profile/edit?id=<?= $displayUser->getId(); ?>">
                    <button class="edit-profile-button button">
                        <span>Profil bearbeiten</span>
                    </button>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!$userItself && $loggedIn): ?>
            <div class="profile-addon-button-container">
                <?php if ($viewHasAdmin): ?>
                <?php if ($displayUser->isDisabled()):?>
                        <form action="profile/enableUser" method="post" class="user-suspend-container">
                            <!-- TODO: Add icon for unban -->
                            <label for="submit-suspend" class="fas fa-unlock enable" title="Nutzer entsperren"></label>
                    <?php else:?>
                        <form action="profile/disableUser" method="post" class="user-suspend-container">
                            <label for="submit-suspend" class="fas fa-gavel disable" title="Nutzer sperren"></label>
                    <?php endif; ?>
                        <input type="text" name="user" hidden value='<?= $displayUser->getId();?>'>
                        <button id="submit-suspend" type="submit" hidden></button>
                        <label for="submit-suspend" hidden>Nutzer sperren</label>
                    </form>
                <?php endif; ?>
                <form action="" class="user-report-container">
                    <button id="submit-report" type="submit" hidden></button>
                    <label for="submit-report" hidden>Nutzer melden</label>
                    <label for="submit-report" class="fas fa-exclamation-triangle" title="Nutzer melden"></label>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <div class="offer-area">
        <?php if (!empty($savedOffers) && $userItself): ?>
        <div class="saved-offers-container">
            <p class="title">Deine Merkliste</p>
            <div class="offer-list-container">
                <?php foreach($savedOffers as $offer): ?>
                <a class="offer-list-link" href="offer?id=<?= $offer->getId();?>">
                    <div class="offer-list-item card">
                        <img src="<?= $offer->getPictureOnPosition(0); ?>" alt="">
                        <p class="name"><?= $offer->getPlatypus()->getName();?></p>
                        <p class="description"><?= $offer->getDescription();?></p>
                        <div class="price-tag-container">
                            <p class="price-tag"><?= $offer->getShortPrice();?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if (!empty($offersByUser)): ?>
        <div class="user-offers-container">
            <p class="title">
                <?php if ($userItself): ?>Deine <?php endif; ?>Angebote
            </p>
            <div class="offer-list-container">
                <?php foreach($offersByUser as $offer): ?>
                <a class="offer-list-link" href="offer?id=<?= $offer->getId();?>">
                    <div class="offer-list-item card">
                        <img src="<?= $offer->getPictureOnPosition(0); ?>" alt="">
                        <p class="name"><?= $offer->getPlatypus()->getName();?></p>
                        <p class="description"><?= $offer->getDescription();?></p>
                        <div class="price-tag-container">
                            <p class="price-tag"><?= $offer->getShortPrice();?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if (empty($savedOffers) && empty($offersByUser)): ?>
        <div class="empty-box">
            <h1>
                <?php if ($userItself): ?>
                <span>Sieht hier ja so leer aus...</span>
                <span class="fas fa-ghost"></span>
                <?php else: ?>
                <span>Der Nutzer hat leider noch keine Angebote.</span>
                <span class="fas fa-box-open"></span>
                <?php endif; ?>
            </h1>
        </div>
        <?php endif; ?>
    </div>
</main>
