<?php use Controller\OfferController;

$offer = OfferController::getOffer($_GET['id']);
$offer->offerClickPlusOne();
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
                            <p><?=$offer->getPrice();?></p>
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
                        <a href="profile" class="view-profile-button button">
                        <div>
                            <p>Verkäuferprofil</p>
                        </div>
                        </a>
                        <a href="profile" class="save-offer-button button">
                        <div>
                            <p>Zur Merkliste</p>
                        </div>
                        </a>
                    </div>
                    <div class="attribute-list card">
                    <div class="attribute-item">
                        <p>Geschlecht: <?=$offer->getPlatypus()->getSex();?></p>
                        <p>Alter: <?=$offer->getPlatypus()->getAgeYears();?></p>
                        <p>Größe: <?=$offer->getPlatypus()->getSize();?></p>
                    </div>
                </div>
                    <?php if((isset($_SESSION['currentUser']))): ?>
                <div class="offer-interactions-container">
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
                        <button id="delete-submit" class="delete-submit button" type="submit" hidden></button>
                        <label for="delete-submit" hidden>Artikel anpassen</label>
                        <label for="delete-submit" class="fas fa-pencil-alt" title="Artikel anpassen"></label>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>