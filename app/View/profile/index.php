<?php
use Controller\ProfileController;
$id_request = $_GET["id"];
$user = ProfileController::getUser($id_request);
?>

<main class="main-page profile-page">
    <div class="profile-area">
        <div class="profile-container card">
            <div class="profile-image">
                <img src="assets/nav/user-circle-solid.svg" alt="profile image">
            </div>
            <div class="profile-displayname">
                <p><?php echo $user->getDisplayName() ?></p>
            </div>
            <div class="profile-rating">
                <span class="fas fa-star checked"></span>
                <span class="fas fa-star checked"></span>
                <span class="fas fa-star checked"></span>
                <span class="fas fa-star checked"></span>
                <span class="far fa-star"></span>
            </div>
            <?php if(($_SESSION['currentUser'])->getId() != $id_request): ?>
            <div class="profile-button-container">
                <a href="chat?id=<?=$id_request ?>" class="button message-button">
                    <div>
                        <p>Nachricht schreiben</p>
                    </div>
                </a>

                <a href="" class="button report-button">
                    <div>
                        <p>Nutzer melden</p>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="main-area">
        <?php if($id_request == $_SESSION['currentUser']->getId()): ?>
        <div class="saved-offers-container">
            <div class="offer-list-container">
                <h2>Merkliste</h2>
                <?php
                    $savedOffers = ProfileController::getSavedOffers($id_request);
                if(!empty($savedOffers)):?>
                <div class="offer-list-container">
                    <?php foreach($savedOffers as $offer): ?>
                        <a class="offer-list-link" href="offer?id=<?= $offer->getOId();?>">
                            <div class="offer-list-item card">
                                <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="">
                                <p class="name"><?= $offer->getName();?></p>
                                <p class="description"><?= $offer->getDescription();?></p>
                                <div class="price-tag-container">
                                    <p class="price-tag"><?= $offer->getPrice();?></p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach;
                    else: ?>
                        <div>
                            <h1>Sorry, du hast leider keine Angebote gespeichert. ¯\_(ツ)_/¯</h1>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="user-offers-container">
            <div class="offer-list-container">
                <h2>Vom Nutzer angeboten</h2>
                <?php
                $offersByUser = ProfileController::getOffersFromUser($id_request);
                if(!empty($offersByUser)):?>
                <div class="offer-list-container">
                    <?php foreach($offersByUser as $offer): ?>
                        <a class="offer-list-link" href="offer?id=<?= $offer->getOId();?>">
                            <div class="offer-list-item card">
                                <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="">
                                <p class="name"><?= $offer->getName();?></p>
                                <p class="description"><?= $offer->getDescription();?></p>
                                <div class="price-tag-container">
                                    <p class="price-tag"><?= $offer->getPrice();?></p>
                                </div>
                            </div>
                        </a>
                    <?php endforeach;
                    else: ?>
                        <div>
                            <h1>Sorry, der Benutzer hat leider keine Angebote. ¯\_(ツ)_/¯</h1>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
    </div>
</main>
