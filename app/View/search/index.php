<?php
    use Hydro\Helper\DataSerialize;
    use Model\OfferModel;

    $searchText = "";
    $sexMaleSelected = "";
    $sexFemaleSelected = "";
    $sex = "";
    $age = array(0, 20);
    $size = array(0, 75);

    if(isset($_POST['search'])): $searchText = $_POST['search']; endif;
    if(isset($_POST['filter-button']) && ($_POST['filter-button'] == 'search')):
        if(isset($_POST['sex']) && $_POST['sex'] == "männlich"): $sexMaleSelected = "selected"; $sex = $_POST['sex']; endif;
        if(isset($_POST['sex']) && $_POST['sex'] == "weiblich"): $sexFemaleSelected = "selected"; $sex = $_POST['sex']; endif;
        if(isset($_POST['age'])): $age = $_POST['age']; endif;
        if(isset($_POST['size'])): $size = $_POST['size']; endif;
    endif;
?>
<main class="main-page filter-page">
    <div class="filter-area">
        <!--
        <div class="filter-container card">
            <form action="search" method="post">
                <input type="hidden" id="search" name="search" value='<?php echo $searchText ?>'>
                <div class="title-container">
                    <p>Filter</p>
                </div>
                <div class="filter-option">
                    <div class="filter-option-header">
                        <p>Geschlecht</p>
                    </div>
                    <div class="filter-option-dropdown">
                        <select id="filter-dropdown-1" name="sex">
                            <option value=""></option>
                            <option value="männlich" <?php echo $sexMaleSelected ?>>männlich</option>
                            <option value="weiblich" <?php echo $sexFemaleSelected ?>>weiblich</option>
                        </select>
                    </div>
                </div>
                <div class="filter-option">
                    <div class="filter-option-header">
                        <p>Alter</p>
                    </div>
                    <div class="filter-option-dropdown">
                        <input type="number" id="age-bottom" name="age-bottom" min="0" max="75" value="<?php echo min($age) ?>">
                        <input type="number" id="age-top" name="age-top" min="0" max="75" value="<?php echo max($age) ?>">
                    </div>
                </div>
                <div class="filter-option">
                    <div class="filter-option-header">
                        <p>Körpergröße</p>
                    </div>
                    <div class="filter-option-dropdown">
                        <input type="number" id="size-bottom" name="size-bottom" min="0" max="75" value="<?php echo min($size) ?>">
                        <input type="number" id="size-top" name="size-top" min="0" max="75" value="<?php echo max($size) ?>">
                    </div>
                </div>
                <div class="filter-button-container">
                    <div class="filter-button-reset">
                        <button name="filter-button" value="reset" class="button reset-button">
                            <p>Zurücksetzen</p>
                        </button>
                        <a href="" class="button reset-button">
                            <div>
                                <p>Zurücksetzen</p>
                            </div>
                        </a>
                    </div>
                    <div class="filter-button-search">
                        <button name="filter-button" value="search" class="button search-button">
                            <p>Suchen</p>
                        </button>
                        <a href="" class="button search-button">
                            <div>
                                <p>Suchen</p>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        -->
        <div class="filter-container card">
            <form action="search" method="post">
                <div class="title-container">
                    <input type="hidden" id="search" name="search" value='<?php echo $searchText ?>'>
                    <p>Filter</p>
                </div>
                <div class="filter-options-container">
                    <div class="attribute-list dropdown-list">
                        <div class="attribute-item dropdown-item">
                            <div class="attribute-item-header dropdown-item-header">
                                <p>Geschlecht</p>
                            </div>
                            <div class="attribute-item-select dropdown-item-select">
                                <label for="filter-sex" hidden>Geschlecht</label>
                                <select name="sex" id="filter-sex">
                                    <option value=""></option>
                                    <option value="männlich" <?php echo $sexMaleSelected ?>>männlich</option>
                                    <option value="weiblich" <?php echo $sexFemaleSelected ?>>weiblich</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="filter-age-range-1">Alter</label>
                        <div class="multi-thumb-slider-container" role="group" aria-labelledby="multi-thumb-slider">
                            <label for="filter-age-range-1" hidden></label>
                            <input type="range" min="0" max="20" value="<?php echo min($age) ?>" id="filter-age-range-1" name="age[]">
                            <label for="filter-age-range-2" hidden></label>
                            <input type="range" min="0" max="20" value="<?php echo max($age) ?>" id="filter-age-range-2" name="age[]">
                        </div>
                    </div>
                    <div>
                        <label for="filter-size-range-1">Größe</label>
                        <div class="multi-thumb-slider-container" role="group" aria-labelledby="multi-thumb-slider">
                            <label for="filter-size-range-1" hidden></label>
                            <input type="range" min="0" max="75" value="<?php echo min($size) ?>" id="filter-size-range-1" name="size[]">
                            <label for="filter-size-range-2" hidden></label>
                            <input type="range" min="0" max="75" value="<?php echo max($size) ?>" id="filter-size-range-2" name="size[]">
                        </div>
                    </div>
                    <div class="filter-button-container">
                        <button type="submit" name="filter-button" value="reset">
                            <span>Zurücksetzen</span>
                            <span class="fas fa-toilet-paper"></span>
                        </button>
                    </div>
                    <div class="filter-button-container">
                        <button type="submit" name="filter-button" value="search">
                            <span>Suchen</span>
                            <span class="fas fa-search"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="main-area">
        <div class="search-results-container">
            <div class="offer-list-container">
                <?php
                $unserializeData = DataSerialize::unserializeData(OfferModel::getData($searchText));
                foreach($unserializeData as $offer):
                    if (((!empty($sex) && $offer->getSex() == $sex) || empty($sex))
                        && ($offer->getAge() >= min($age))
                        && ($offer->getAge() <= max($age))
                        && ($offer->getSize() >= min($size))
                        && ($offer->getSize() <= max($size))):
                        ?>
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
                <?php
                    endif;
                endforeach;?>
            </div>
        </div>
    </div>
</main>