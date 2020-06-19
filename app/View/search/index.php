<?php
    use Controller\SearchController;

    $searchText = $_POST['search'];
    $sex = "";
    $sexMaleSelected = "";
    $sexFemaleSelected = "";
    $age = array(0, 20);
    $size = array(0, 75);
    $weight = array(0, 3000);

    if(isset($_POST['sex'])): $sex = $_POST['sex']; endif;
    if(isset($_POST['sex'])):
        $sex = $_POST['sex'];
        if($sex == "männlich"): $sexMaleSelected = "selected"; endif;
        if($sex == "weiblich"): $sexFemaleSelected = "selected"; endif;
    endif;
    if(isset($_POST['age'])):
        $age = $_POST['age'];
    endif;
    if(isset($_POST['size'])):
        $size = $_POST['size'];
    endif;
    if(isset($_POST['weight'])):
        $weight = $_POST['weight'];
    endif;?>
<main class="main-page filter-page">
    <div class="filter-area">
        <div class="filter-container card">
            <form action="search" method="post">
                <div class="title-container">
                    <input type="hidden" name="search" value='<?php echo $searchText ?>'>
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
                    <div>
                        <label for="filter-weight-range-1">Gewicht</label>
                        <div class="multi-thumb-slider-container" role="group" aria-labelledby="multi-thumb-slider">
                            <label for="filter-weight-range-1" hidden></label>
                            <input type="range" min="0" max="3000" value="<?php echo min($weight) ?>" id="filter-weight-range-1" name="weight[]">
                            <label for="filter-weight-range-2" hidden></label>
                            <input type="range" min="0" max="3000" value="<?php echo max($weight) ?>" id="filter-weight-range-2" name="weight[]">
                        </div>
                    </div>
                    <div class="filter-button-container">
                        <button class="reset-button" type="submit" name="filter-button" value="reset">
                            <span>Zurücksetzen</span>
                            <span class="fas fa-toilet-paper"></span>
                        </button>
                    </div>
                    <div class="filter-button-container">
                        <button class="search-button" type="submit" name="filter-button" value="search">
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
            <?php
            $offers = SearchController::getOffers($searchText, $sex, $age, $size, $weight);
            if(!empty($offers)):?>
            <div class="offer-list-container">
            <?php foreach($offers as $offer): ?>
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
                    <h1>Sorry, es gibt leider keine passenden Angebote. ¯\_(ツ)_/¯</h1>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>