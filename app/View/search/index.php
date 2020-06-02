<?php
    use Hydro\Helper\DataSerialize;
    use Model\OfferModel;

    $searchText = "";
    $sexMaleSelected = "";
    $sexFemaleSelected = "";
    $age_bottom = "";
    $age_top = "";
    $size_bottom = "";
    $size_top = "";

    if(isset($_POST['search'])): $searchText = $_POST['search']; endif;
    if(isset($_POST['sex']) && $_POST['sex'] == "männlich"): $sexMaleSelected = "selected"; endif;
    if(isset($_POST['sex']) && $_POST['sex'] == "weiblich"): $sexFemaleSelected = "selected"; endif;
    if(isset($_POST['age-bottom'])): $age_bottom = $_POST['age-bottom']; endif;
    if(isset($_POST['age-top'])): $age_top = $_POST['age-top']; endif;
    if(isset($_POST['size-bottom'])): $size_bottom = $_POST['size-bottom']; endif;
    if(isset($_POST['size-top'])): $size_top = $_POST['size-top']; endif;
?>
<div class="main-page filter-page">
    <div class="filter-area">
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
                        <button type="reset" class="button reset-button">
                            <p>Zurücksetzen</p>
                        </button>
                        <!--<a href="" class="button reset-button">
                            <div>
                                <p>Zurücksetzen</p>
                            </div>
                        </a>-->
                    </div>
                    <div class="filter-button-search">
                        <button class="button search-button">
                            <p>Suchen</p>
                        </button>
                        <!--<a href="" class="button search-button">
                            <div>
                                <p>Suchen</p>
                            </div> -->
                        </a>
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
                    if (((!empty($_POST['sex']) && $offer->getSex() == $_POST['sex']) || empty($_POST['sex']))
                        && ((!empty($_POST['age-bottom']) && $offer->getAge() >= $_POST['age-bottom']) || empty($_POST['age-bottom']))
                        && ((!empty($_POST['age-top']) && $offer->getAge() <= $_POST['age-top']) || empty($_POST['age-top']))
                        && ((!empty($_POST['size-bottom']) && $offer->getSize() >= $_POST['size-bottom']) || empty($_POST['size-bottom']))
                        && ((!empty($_POST['size-top']) && $offer->getSize() <= $_POST['size-top']) || empty($_POST['size-top']))):
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