<?php
use Controller\OfferController;

$offer = OfferController::getOffer($_GET['id']);
OfferController::offerClickPlusOne($offer);
$seller = $offer->getUser();
$zipcode = $offer->getZipcode();
$zipcoordinates = $offer->getZipCoordinates();
$location = $zipcoordinates->getName();
$map_lat = $zipcoordinates->getLat();
$map_lon = $zipcoordinates->getLon();
$isSaved = false;

if(isset($_SESSION['currentUser'])):
    $isSaved = OfferController::isOfferInSavedList($_GET['id']);
endif;
?>
<main class="main-page">
    <div class="main-area">
        <div class="offer-area">
            <div class="offer-container card">
                <img src="<?= $offer->getImageOnPosition(0); ?>" alt="offer image">
                <div class="description-container">
                    <p class="name"><?=$offer->getPlatypus()->getName();?></p>
                    <p class="description"><?=$offer->getDescription();?></p>
                </div>
                <div class="price-tag-container">
                    <div class="price-tag">
                        <p><?=$offer->getShortPrice();?></p>
                        <?php if($offer->getNegotiable()): ?>
                        <span>VB</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="side-container">
                <div class="offer-buttons-container">
                    <a href="chat?id=<?=$offer->getUser()->getId() ?>" class="send-message-button button">
                        <div>
                            <p>Nachricht schreiben</p>
                        </div>
                    </a>
                    <?php if($isSaved):?>
                    <form action="offer/removeFromSavedList" method="post">
                        <input type="text" id="save-id" name="offerId" hidden value="<?=$offer->getId();?>">
                        <label for="save-id" hidden>Speicher-ID</label>
                        <button class="save-offer-button button">
                            <span>Von der Merkliste entfernen</span>
                        </button>
                    </form>
                    <?php else: ?>
                    <form action="offer/offerToSavedList" method="post">
                        <input type="text" id="save-id" name="offerId" hidden value="<?=$offer->getId();?>">
                        <label for="save-id" hidden>Speicher-ID</label>
                        <button class="save-offer-button button">
                            <span>Zur Merkliste</span>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
                <div class="profile-container card">
                    <a href="profile?id=<?= $seller->getId() ?>">
                        <img src="<?= $seller->getPicture(); ?>" alt="user-avatar">
                    </a>
                    <div>
                        <a href="profile?id=<?= $seller->getId() ?>">
                            <p><?= $seller->getDisplayName() ?></p>
                        </a>
                        <div class="user-rating">
                            <span class="fas fa-star" id="user-rating-5"></span>
                            <span class="fas fa-star" id="user-rating-4"></span>
                            <span class="fas fa-star" id="user-rating-3"></span>
                            <span class="fas fa-star" id="user-rating-2"></span>
                            <span class="fas fa-star" id="user-rating-1"></span>
                        </div>
                    </div>
                </div>
                <div class="attribute-list card">
                    <div class="attribute-item">
                        <p><strong>Geschlecht:</strong><br>&nbsp;<?=$offer->getPlatypus()->getSex();?></p>
                        <p><strong>Alter:</strong><br>&nbsp;<?=$offer->getPlatypus()->getAgeYears();?> Jahre</p>
                        <p><strong>Größe:</strong><br>&nbsp<?=$offer->getPlatypus()->getSize();?>cm</p>
                        <p><strong>Gewicht:</strong><br>&nbsp<?=$offer->getPlatypus()->getWeight();?>g</p>
                    </div>
                    <div class="attribute-item">
                        <p>Erstellt: <strong class="date-display">
                                <?= $offer->getCreateDate() ?> UTC
                            </strong></p>
                        <?php if(!empty($offer->getEditDate())): ?>
                        <p>Zuletzt bearbeitet: <strong class="date-display">
                                <?= $offer->getEditDate() ?> UTC</strong></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="offer-interactions-container">
                    <?php if((isset($_SESSION['currentUser']))): ?>
                    <form action="report">
                        <input type="text" id="report-id" name="id" hidden value="<?=$offer->getId();?>">
                        <label for="report-id" hidden>Änderungs-ID</label>
                        <button id="submit-report" class="delete-submit button" type="submit" hidden></button>
                        <label for="submit-report" hidden>Artikel melden</label>
                        <label for="submit-report" class="fas fa-exclamation-triangle" title="Artikel melden"></label>
                    </form>
                    <?php if($_SESSION["currentUser"]->getId() == $seller->getId() || $_SESSION["currentUser"]->isAdmin()): ?>
                    <form action="offer/delete" method="post" data-needs-confirmation>
                        <input type="text" id="delete-platypus-id" name="platypusId" hidden value="<?=$offer->getPlatypus()->getId();?>">
                        <input type="text" id="delete-offer-id" name="offerId" hidden value="<?=$offer->getId();?>">
                        <label for="delete-id" hidden>Änderungs-ID</label>
                        <button id="submit-delete" class="delete-button button" type="submit" hidden></button>
                        <label for="submit-delete" hidden>Artikel löschen</label>
                        <label for="submit-delete" class="fas fa-trash-alt" title="Artikel löschen"></label>
                    </form>
                    <form action="create">
                        <input type="text" id="create-id" name="id" hidden value="<?=$offer->getId();?>">
                        <label for="create-id" hidden>Änderungs-ID</label>
                        <button id="submit-create" class="create-button button" type="submit" hidden></button>
                        <label for="submit-create" hidden>Artikel anpassen</label>
                        <label for="submit-create" class="fas fa-pencil-alt" title="Artikel anpassen"></label>
                    </form>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if (!(is_null($zipcode) || $zipcode === "")): ?>
        <div class="map-container card no-js-hide">
            <input type="hidden" id="map-lat" value="<?= $map_lat ?>">
            <input type="hidden" id="map-lon" value="<?= $map_lon ?>">
            <div class="map-text-container">
                <h3>Standort:</h3>
                <p><?= $zipcode ?></p>
                <p><?= $location ?></p>
            </div>
            <div id="map"></div>
        </div>
        <?php endif; ?>
    </div>
    <div class="confirm-changes-container-background" id="confirm-changes-container" hidden>
        <div>
            <div class="confirm-changes-container card">
                <h2>Wirklich löschen?</h2>
                <div class="confirm-changes-diff-container" id="confirm-changes-diff">
                </div>
                <button title="Wirklich löschen" class="delete" data-confirm="confirm">
                    <span class="fas fa-trash-alt"></span>
                </button>
                <button title="Abbrechen" data-confirm="cancel">
                    <span class="fas fa-times"></span>
                </button>
            </div>
        </div>
    </div>
</main>
