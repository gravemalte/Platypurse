<?php use Controller\OfferController;
use Hydro\Helper\DataSerialize;
use Model\OfferModel; ?>
<main class="main-page">
    <div class="main-area">
        <div class="offer-area">
            <?php if(isset($_GET['id'])):
                $offer = DataSerialize::unserializeData(OfferModel::getData($_GET['id']))[0];
            ?>
            <div class="offer-container card">
                    <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="offer image">
                    <div class="description-container">
                        <p class="name"><?php echo $offer->getTitle();?></p>
                        <p class="description"><?php echo $offer->getDescription();?></p>
                    </div>
                    <div class="price-tag-container">
                        <div class="price-tag">
                            <p><?php echo $offer->getPrice();?></p>
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
                        <p>Geschlecht: <?php echo $offer->getSex();?></p>
                        <p>Alter: <?php echo $offer->getAge();?></p>
                        <p>Größe: <?php echo $offer->getSize();?></p>
                    </div>
                </div>
                    <?php if((isset($_SESSION['user-ID']))): ?>
                <div class="offer-interactions-container">
                    <form action="offer/delete">
                        <input type="text" id="delete-id" name="id" hidden value="<?php echo $offer->getId();?>">
                        <label for="delete-id" hidden>Änderungs-ID</label>
                        <button id="submit-delete" class="delete-button button" type="submit" hidden></button>
                        <label for="submit-delete" hidden>Artikel löschen</label>
                        <label for="submit-delete" class="fas fa-trash-alt" title="Artikel löschen"></label>
                    </form>
                    <form action="create">
                        <input type="text" id="create-id" name="id" hidden value="<?php echo $offer->getId();?>">
                        <label for="create-id" hidden>Änderungs-ID</label>
                        <button id="delete-submit" class="delete-submit button" type="submit" hidden></button>
                        <label for="delete-submit" hidden>Artikel anpassen</label>
                        <label for="delete-submit" class="fas fa-pencil-alt" title="Artikel anpassen"></label>
                    </form>
                </div>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div>
                <h1>Sorry, Angebot konnte nicht gefunden werden. ¯\_(ツ)_/¯</h1>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>