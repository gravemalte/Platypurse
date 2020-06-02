<?php
    use Hydro\Helper\DataSerialize;
    use Model\OfferModel;

    $searchText = "";
    $sexMaleSelected = "";
    $sexFemaleSelected = "";
    $sex = "";
    $age_bottom = "";
    $age_top = "";
    $size_bottom = "";
    $size_top = "";

    if(isset($_POST['search'])): $searchText = $_POST['search']; endif;
    if(isset($_POST['filter-button']) && ($_POST['filter-button'] == 'search')):
        if(isset($_POST['sex']) && $_POST['sex'] == "männlich"): $sexMaleSelected = "selected"; $sex = $_POST['sex']; endif;
        if(isset($_POST['sex']) && $_POST['sex'] == "weiblich"): $sexFemaleSelected = "selected"; $sex = $_POST['sex']; endif;
        if(isset($_POST['age-bottom'])): $age_bottom = $_POST['age-bottom']; endif;
        if(isset($_POST['age-top'])): $age_top = $_POST['age-top']; endif;
        if(isset($_POST['size-bottom'])): $size_bottom = $_POST['size-bottom']; endif;
        if(isset($_POST['size-top'])): $size_top = $_POST['size-top']; endif;
    endif;
?>
<div class="main-page filter-page">
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
                        <input type="number" id="age-bottom" name="age-bottom" min="0" max="75" value="<?php echo $age_bottom ?>">
                        <input type="number" id="age-top" name="age-top" min="0" max="75" value="<?php echo $age_top?>">
                    </div>
                </div>
                <div class="filter-option">
                    <div class="filter-option-header">
                        <p>Körpergröße</p>
                    </div>
                    <div class="filter-option-dropdown">
                        <input type="number" id="size-bottom" name="size-bottom" min="0" max="75" value="<?php echo $size_bottom ?>">
                        <input type="number" id="size-top" name="size-top" min="0" max="75" value="<?php echo $size_top ?>">
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
                            <input type="range" min="0" max="20" value="0" id="filter-age-range-1">
                            <label for="filter-age-range-2" hidden></label>
                            <input type="range" min="0" max="20" value="20" id="filter-age-range-2">
                        </div>
                    </div>
                    <div>
                        <label for="filter-size-range-1">Größe</label>
                        <div class="multi-thumb-slider-container" role="group" aria-labelledby="multi-thumb-slider">
                            <label for="filter-size-range-1" hidden></label>
                            <input type="range" min="0" max="75" value="0" id="filter-size-range-1" name="size">
                            <label for="filter-size-range-2" hidden></label>
                            <input type="range" min="0" max="75" value="75" id="filter-size-range-2" name="size">
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
                        && ((!empty($age_bottom) && $offer->getAge() >= $age_bottom) || empty($age_bottom))
                        && ((!empty($age_top) && $offer->getAge() <= $age_top) || empty($age_top))
                        && ((!empty($size_bottom) && $offer->getSize() >= $size_bottom) || empty($size_bottom))
                        && ((!empty($size_top) && $offer->getSize() <= $size_top) || empty($size_top))):
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
</div>