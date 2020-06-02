<?php
use \Controller\HomeController;
use Hydro\Helper\DataSerialize;
use Model\OfferModel;

?>
<main class="main-page">
    <div class="main-area">
        <!-- Static hot offer as long there is no proper database -->
        <?php $hotOffer = DataSerialize::unserializeData(OfferModel::getData())[0]?>
        <a href="offer?id=<?php echo $hotOffer->getId();?>">
            <div class="hot-offer-container card">
                <div class="annotation">
                    <p>Hot Offer</p>
                </div>
                <div class="hot-offer">
                    <div class="img-container">
                        <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="hot offer image">
                    </div>
                    <div class="side-text">
                        <h1 class="name"><?php echo $hotOffer->getTitle();?></h1>
                        <p class="description"><?php echo $hotOffer->getDescription();?></p>
                        <div class="attribute-list">
                            <p>Geschlecht: <?php echo $hotOffer->getSex();?></p>
                            <p>Alter: <?php echo $hotOffer->getAge();?></p>
                            <p>Größe: <?php echo $hotOffer->getSize();?></p>
                        </div>
                        <h2 class="view-counter">123</h2>
                        <p class="view-description">Aufrufe in den letzten 24H</p>
                    </div>
                    <div class="price-tag">
                        <p><?php echo $hotOffer->getPrice();?></p>
                    </div>
                </div>
            </div>
        </a>
        <div class="title-container">
            <p>Neuste Angebote</p>
        </div>
        <div class="offer-list-container">
            <?php
                $unserializeData = DataSerialize::unserializeData(OfferModel::getData());

                foreach($unserializeData as $offer): ?>
            <a class="offer-list-link" href="offer?id=<?php echo $offer->getId();?>">
                <div class="offer-list-item card">
                    <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="">
                    <p class="name"><?php echo $offer->getTitle();?></p>
                    <p class="description"><?php echo $offer->getDescription();?></p>
                    <div class="price-tag-container">
                        <p class="price-tag"><?php echo $offer->getPrice();?></p>
                    </div>
                </div>
            </a>
            <?php endforeach;?>
        </div>
    </div>
</main>