<?php
    use Hydro\Helper\DataSerialize;
    use Model\OfferModel;
?>
<div class="main-page filter-page">
    <div class="filter-area">
        <div class="filter-container card">
            <div class="title-container">
                <p>Filter</p>
            </div>
            <div class="filter-option">
                <div class="filter-option-header">
                    <p>Geschlecht</p>
                </div>
                <div class="filter-option-dropdown">
                    <select id="filter-dropdown-1" name="sex">
                        <option value="male">männlich</option>
                        <option value="female">weiblich</option>
                    </select>
                </div>
            </div>
            <div class="filter-option">
                <div class="filter-option-header">
                    <p>Alter</p>
                </div>
                <div class="filter-option-dropdown">
                    <input type="number" id="age-bottom" name="age-bottom" min="0" max="75">
                    <input type="number" id="age-top" name="age-top" min="0" max="75">
                </div>
            </div>
            <div class="filter-option">
                <div class="filter-option-header">
                    <p>Körpergröße</p>
                </div>
                <div class="filter-option-dropdown">
                    <input type="number" id="size-bottom" name="size-bottom" min="0" max="75">
                    <input type="number" id="size-top" name="size-top" min="0" max="75">
                </div>
            </div>
            <div class="filter-button-container">
                <div class="filter-button-reset">
                    <a href="" class="button reset-button">
                        <div>
                            <p>Zurücksetzen</p>
                        </div>
                    </a>
                </div>
                <div class="filter-button-search">
                    <a href="" class="button search-button">
                        <div>
                            <p>Suchen</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-area">
        <div class="search-results-container">
            <div class="offer-list-container">
                <?php
                $unserializeData = DataSerialize::unserializeData(OfferModel::getData($_POST['search']));

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
    </div>
</div>