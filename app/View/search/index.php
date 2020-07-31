<?php

use Controller\SearchController;

$searchText = "";
$sex = "";
$sexMaleSelected = "";
$sexFemaleSelected = "";
$age = array(0, 20);
$size = array(0, 75);
$weight = array(0, 3000);

if (isset($_GET['search'])) {
    $searchText = htmlspecialchars(strip_tags($_GET['search']));
}

if(isset($_GET['filter-button']) && $_GET['filter-button'] != 'reset'):
    if (isset($_GET['sex'])):
        $sex = $_GET['sex'];
        if ($sex == "männlich"): $sexMaleSelected = "selected"; endif;
        if ($sex == "weiblich"): $sexFemaleSelected = "selected"; endif;
    endif;
    if (isset($_GET['age'])):
        $age = $_GET['age'];
    endif;
    if (isset($_GET['size'])):
        $size = $_GET['size'];
    endif;
    if (isset($_GET['weight'])):
        $weight = $_GET['weight'];
    endif;
endif;

$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * 30;
$offerCount = SearchController::getOffers($offset, $searchText, $sex, $age, $size, $weight, true);

if ($offset > $offerCount) {
    $page = round($offerCount / 30, 0);
    $offset = ($page - 1) * 30;
}
?>
<main class="main-page filter-page">
    <div class="filter-area">
        <div class="filter-container card">
            <form action="search" method="get">
                <input type="hidden" name="page" value="1">
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
                                    <option id="sex-none-option" value="">keine Auswahl</option>
                                    <option value="männlich" <?php echo $sexMaleSelected ?>>männlich</option>
                                    <option value="weiblich" <?php echo $sexFemaleSelected ?>>weiblich</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="filter-age-range-1">Alter</label>
                        <div class="multi-thumb-slider-show-data">
                            <span data-show-multi-thumb-slider="filter-age-range-1"></span>
                            <span data-show-multi-thumb-slider="filter-age-range-2"></span>
                        </div>
                        <div class="multi-thumb-slider-container" role="group" aria-labelledby="multi-thumb-slider">
                            <label for="filter-age-range-1" hidden></label>
                            <input type="range" min="0" max="20" value="<?php echo min($age) ?>" id="filter-age-range-1"
                                   name="age[]">
                            <label for="filter-age-range-2" hidden></label>
                            <input type="range" min="0" max="20" value="<?php echo max($age) ?>" id="filter-age-range-2"
                                   name="age[]">
                        </div>
                    </div>
                    <div>
                        <label for="filter-size-range-1">Größe</label>
                        <div class="multi-thumb-slider-show-data">
                            <span data-show-multi-thumb-slider="filter-size-range-1"></span>
                            <span data-show-multi-thumb-slider="filter-size-range-2"></span>
                        </div>
                        <div class="multi-thumb-slider-container" role="group" aria-labelledby="multi-thumb-slider">
                            <label for="filter-size-range-1" hidden></label>
                            <input type="range" min="0" max="75" value="<?php echo min($size) ?>"
                                   id="filter-size-range-1" name="size[]">
                            <label for="filter-size-range-2" hidden></label>
                            <input type="range" min="0" max="75" value="<?php echo max($size) ?>"
                                   id="filter-size-range-2" name="size[]">
                        </div>
                    </div>
                    <div>
                        <label for="filter-weight-range-1">Gewicht</label>
                        <div class="multi-thumb-slider-show-data">
                            <span data-show-multi-thumb-slider="filter-weight-range-1"></span>
                            <span data-show-multi-thumb-slider="filter-weight-range-2"></span>
                        </div>
                        <div class="multi-thumb-slider-container" role="group" aria-labelledby="multi-thumb-slider">
                            <label for="filter-weight-range-1" hidden></label>
                            <input type="range" min="0" max="3000" value="<?php echo min($weight) ?>"
                                   id="filter-weight-range-1" name="weight[]">
                            <label for="filter-weight-range-2" hidden></label>
                            <input type="range" min="0" max="3000" value="<?php echo max($weight) ?>"
                                   id="filter-weight-range-2" name="weight[]">
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
            $offers = SearchController::getOffers($offset, $searchText, $sex, $age, $size, $weight);
            if (!empty($offers)): ?>
            <div class="offer-list-container" id="offers">
                <?php foreach ($offers as $offer): ?>
                    <a class="offer-list-link" href="offer?id=<?= $offer->getId(); ?>">
                        <div class="offer-list-item card">
                            <img src="<?= $offer->getImage()->getSrc(); ?>" alt="">
                            <p class="name"><?= $offer->getPlatypus()->getName(); ?></p>
                            <p class="description"><?= $offer->getDescription(); ?></p>
                            <div class="price-tag-container">
                                <p class="price-tag"><?= $offer->getPrice(); ?></p>
                            </div>
                        </div>
                    </a>
                <?php endforeach ?>
                <div class="pagination-container" id="pagination">
                    <form action="search" method="get" class="pagination" id="load-more-form">
                        <input type="hidden" name="search" value="<?= $searchText ?>">
                        <input type="hidden" name="sex" value="<?= $sex ?>">
                        <input type="hidden" name="age[]" value="<?= $age[0] ?>">
                        <input type="hidden" name="age[]" value="<?= $age[1] ?>">
                        <input type="hidden" name="size[]" value="<?= $size[0] ?>">
                        <input type="hidden" name="size[]" value="<?= $size[1] ?>">
                        <input type="hidden" name="weight[]" value="<?= $weight[0] ?>">
                        <input type="hidden" name="weight[]" value="<?= $weight[1] ?>">
                        <input type="hidden" name="filter-button" value="search">
                        <noscript>
                            <button
                                    type="submit"
                                    name="page"
                                    value="<?= $page - 1 ?>"
                                    class="navigation"
                                <?php if($page <= 1): ?>
                                    style="visibility: hidden"
                                <?php endif ?>
                            >&LT;</button>
                            <p><?= $page ?></p>
                            <button
                                    type="submit"
                                    name="page"
                                    value="<?= $page + 1 ?>"
                                    class="navigation"
                                <?php if(($offset + 30) >= $offerCount): ?>
                                    style="visibility: hidden"
                                <?php endif ?>
                            >&GT;</button>
                        </noscript>
                        <button
                                type="submit"
                                name="page"
                                class="no-js-hide load-more"
                                id="load-more-button"
                                value="<?= $page + 1 ?>"
                            <?php if(($offset + 30) >= $offerCount): ?>
                                style="visibility: hidden"
                            <?php endif ?>
                        >
                            Mehr laden
                        </button>
                    </form>
                    <input type="hidden" id="offerCount" value="<?= $offerCount ?>">
                </div>
                <?php else: ?>
                    <div>
                        <h1>Sorry, es gibt leider keine passenden Angebote. ¯\_(ツ)_/¯</h1>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
