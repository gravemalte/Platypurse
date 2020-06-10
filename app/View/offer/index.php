<?php
use Controller\OfferController;
use Hydro\Helper\Date;

$offer = OfferController::getOffer($_GET['id']);
$offer->offerClickPlusOne();
$seller = $offer->getUser();
$isSaved = false;
if(isset($_SESSION['currentUser'])):
    $isSaved = OfferController::getOfferFromSavedList($_GET['id']);
endif;
?>
<main class="main-page">
    <div class="main-area">
        <div class="offer-area">
            <div class="offer-container card">
                <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="offer image">
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
                    <a href="chat" class="send-message-button button">
                        <div>
                            <p>Nachricht schreiben</p>
                        </div>
                    </a>
                    <?php if($isSaved):?>
                    <form action="offer/removeFromSavedList" method="post">
                        <input type="text" id="save-id" name="offerId" hidden value="<?=$offer->getId();?>">
                        <label for="save-id" hidden>Speicher-ID</label>
                        <button class="save-offer-button button">
                            Von der Merkliste entfernen
                        </button>
                    </form>
                    <?php else: ?>
                        <form action="offer/offerToSavedList" method="post">
                            <input type="text" id="save-id" name="offerId" hidden value="<?=$offer->getId();?>">
                            <label for="save-id" hidden>Speicher-ID</label>
                            <button class="save-offer-button button">
                                Zur Merkliste
                            </button>
                            <!-- TODO: Remove link (design as it was for reference) and style button -->
                            <a href="offer/offerToSavedList(<?= $offer->getId()?>)" class="save-offer-button button">
                                <div>
                                    <p>Zur Merkliste</p>
                                </div>
                            </a>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="profile-container card">
                    <a href="profile?id=<?= $seller->getId() ?>">
                        <img src="assets/nav/user-circle-solid.svg" alt="user-avatar">
                    </a>
                    <div>
                        <a href="profile?id=<?= $seller->getId() ?>">
                            <p><?= $seller->getDisplayName() ?></p>
                        </a>
                        <div class="rating">
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
                        <p><strong>Größe:</strong><br>&nbsp<?=$offer->getPlatypus()->getSize();?> cm</p>
                        <!--<p><strong>Gewicht:</strong><br>&nbsp<?=$offer->getPlatypus()->getWeight();?> kg</p>-->
                    </div>
                    <div class="attribute-item">
                        <p>Erstellt: <strong>
                                <?= Date::niceDate($offer->getCreateDate()) ?>
                            </strong></p>
                        <?php if(!empty($offer->getEditDate())): ?>
                        <p>Zuletzt bearbeitet: <strong>
                                <?= Date::niceDate($offer->getEditDate()) ?></strong></p>
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
                    <form action="offer/delete" method="post">
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
    </div>
</main>
