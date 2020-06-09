<?php
use Hydro\Helper\DataSerialize;
use Model\OfferModel;
use Controller\CreateController;
use Controller\OfferController;
?>

<main class="main-page">
    <div class="main-area">
        <div class="create-offer-container card">
            <?php if(isset($_GET['id'])):
                $offer = OfferController::getOffer($_GET['id']); ?>
            <form action="create/update" method="post">
                <input type="hidden" name="offerId" value='<?php echo $offer->getId();?>'>
                <input type="hidden" name="platypusId" value='<?php echo $offer->getPlatypus()->getId();?>'>
            <?php else: ?>
            <form action="create/create" method="post">
            <?php endif;?>
                <div class="main-container">
                    <div class="name-container main-input-container">
                        <p class="name">Name</p>
                        <div class="input-container">
                            <label for="name">
                                <input type="text" placeholder="Name" id="name" name="name" required value="<?php
                                    if(isset($_GET['id'])):
                                        echo $offer->getPlatypus()->getName() ;
                                    endif;?>">
                            </label>
                        </div>
                    </div>
                    <div class="name-container main-input-container">
                        <p class="name">Preis</p>
                        <div class="input-container">
                            <label for="price">
                                <input
                                        type="text"
                                        placeholder="Preis"
                                        id="price"
                                        pattern="\d+([,\.]\d{1,2})?"
                                        inputmode="decimal"
                                        name="price"
                                        required
                                        value="<?php
                                if(isset($_GET['id'])):
                                    echo $offer->getPrice();
                                endif;?>">
                            </label>
                        </div>
                    </div>
                    <div class="img-container main-input-container">
                        <p class="name">Bilder</p>
                        <div class="drag-drop-container">
                            <input id="create-image" type="file" multiple accept="image/*" name="image" hidden>
                            <label for="create-image">
                                <span>Drag'n'Drop</span>
                                <span>Bilder hier</span>
                                <span class="far fa-caret-square-down"></span>
                                <span>Oder hier klicken</span>
                            </label>
                        </div>
                    </div>
                    <div class="description-container main-input-container">
                        <p class="name">Beschreibung</p>
                        <div class="input-container">
                            <label for="description">
                                <?php $description = "";
                                if(isset($_GET['id'])):
                                    $description = $offer->getDescription();
                                endif;?>
                                <textarea placeholder="Beschreibung" id="description"
                                          name="description"><?= $description?></textarea>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="side-container">
                    <div class="attribute-list dropdown-list">
                        <div class="attribute-item dropdown-item">
                            <div class="attribute-item-header dropdown-item-header">
                                <p>Geschlecht</p>
                            </div>
                            <div class="attribute-item-select dropdown-item-select">
                                <label for="sex">
                                    <select name="sex" id="sex" >
                                        <option value="männlich" <?php
                                        if(isset($_GET['id']) && $offer->getPlatypus()->getSex() == "männlich"):
                                            echo "selected";
                                        endif;?>>Männlich</option>
                                        <option value="weiblich" <?php
                                        if(isset($_GET['id']) && $offer->getPlatypus()->getSex() == "weiblich"):
                                            echo "selected";
                                        endif;?>>Weiblich</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div class="attribute-item dropdown-item">
                            <div class="attribute-item-header dropdown-item-header">
                                <p>Alter</p>
                            </div>
                            <div class="attribute-item-select dropdown-item-select">
                                <label for="age" hidden>Alter</label>
                                <input type="number" id="age" name="age" min="0" max="20" value="<?php
                                if(isset($_GET['id'])):
                                    echo $offer->getPlatypus()->getAgeYears();
                                endif;?>">
                                <p>Jahre</p>
                            </div>
                        </div>
                        <div class="attribute-item dropdown-item">
                            <div class="attribute-item-header dropdown-item-header">
                                <p>Körpergröße</p>
                            </div>
                            <div class="attribute-item-select dropdown-item-select">
                                <label for="size" hidden>Körpergröße</label>
                                <input type="number" id="size" name="size" min="0" max="75" value="<?php
                                if(isset($_GET['id'])):
                                    echo $offer->getPlatypus()->getSize();
                                endif;?>">
                                <p>cm</p>
                            </div>
                        </div>
                    </div>
                    <div class="buttons-container">
                        <button type="submit" hidden id="create-submit"></button>
                        <label for="create-submit" class="fas fa-clipboard-check"
                               title="Angebot erstellen"
                        ></label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>