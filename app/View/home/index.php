<?php
use \Controller\HomeController;
?>
<main class="main-page">
    <div class="main-area">
        <?php
        $hotOffer = HomeController::getHotOffer();
        if(!empty($hotOffer)):?>
            <a href="offer?id=<?= $hotOffer->getId();?>">
                <div class="hot-offer-container card">
                    <div class="annotation">
                        <p>Hot Offer</p>
                    </div>
                    <div class="hot-offer">
                        <div class="img-container">
                            <img src="<?= $hotOffer->getImage()->getSrc(); ?>" alt="hot offer image">
                        </div>
                        <div class="side-text">
                            <h1 class="name"><?= $hotOffer->getPlatypus()->getName();?></h1>
                            <p class="description"><?= $hotOffer->getDescription();?></p>
                            <div class="attribute-list">
                                <p>Geschlecht: <?= $hotOffer->getPlatypus()->getSex();?></p>
                                <p>Alter: <?= $hotOffer->getPlatypus()->getAgeYears();?> Jahre</p>
                                <p>Größe: <?= $hotOffer->getPlatypus()->getSize();?>cm</p>
                                <p>Gewicht: <?= $hotOffer->getPlatypus()->getWeight();?>g</p>
                            </div>
                            <h2 class="view-counter"><?= $hotOffer->getClicks();?></h2>
                            <p class="view-description">Aufrufe in den letzten 24H</p>
                        </div>
                        <div class="price-tag">
                            <p><?= $hotOffer->getPrice();?></p>
                        </div>
                    </div>
                </div>
            </a>
        <?php else: ?>
            <div>
                <h1>Sorry, es gibt gerade leider kein Hot Offer. ¯\_(ツ)_/¯</h1>
            </div>
        <?php endif; ?>
            <?php $offers = HomeController::getNewestOffers();
            if(!empty($offers)):?>
            <div class="title-container">
                <p>Neuste Angebote</p>
            </div>
            <div class="offer-list-container">
                <?php foreach($offers as $offer):?>
                <a class="offer-list-link" href="offer?id=<?= $offer->getId();?>">
                    <div class="offer-list-item card">
                        <img src="<?= $offer->getImage()->getSrc(); ?>" alt="">
                        <p class="name"><?= $offer->getPlatypus()->getName();?></p>
                        <p class="description"><?= $offer->getDescription();?></p>
                        <div class="price-tag-container">
                            <p class="price-tag"><?= $offer->getPrice();?></p>
                        </div>
                    </div>
                </a>
                <?php endforeach;
            else: ?>
                <div>
                    <h1>Sorry, es gibt gerade leider keine Angebote. ¯\_(ツ)_/¯</h1>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>