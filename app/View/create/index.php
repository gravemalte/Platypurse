<?php
use Controller\OfferController;

$currentUser = $_SESSION['currentUser'];
$isUpdate = isset($_GET['id']);
if($isUpdate):
    $offerId = $_GET['id'];
    $offer = OfferController::getOffer($offerId);
    $userIsOwner = $currentUser->getId() == $offer->getUser()->getId();
    $userIsAdmin = $currentUser->isAdmin();
endif;
?>

<main class="main-page">
    <div class="main-area">
        <div class="create-offer-container card">
            <form action="create/processInput" method="post" enctype="multipart/form-data" >
            <?php if($isUpdate && ($userIsOwner || $userIsAdmin)):?>
                <input type="hidden" name="offerId" value='<?php echo $offer->getId();?>'>
            <?php endif;?>
                <div class="main-container">
                    <div class="name-container main-input-container">
                        <p class="name">Name</p>
                        <div class="input-container">
                            <label for="name">
                                <input type="text" placeholder="Name" id="name" name="name" required value="<?php
                                    if($isUpdate && ($userIsOwner || $userIsAdmin)):
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
                                if($isUpdate && ($userIsOwner || $userIsAdmin)):
                                    echo $offer->getPrice(false);
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
                                if($isUpdate && ($userIsOwner || $userIsAdmin)):
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
                                        if(($isUpdate && ($userIsOwner || $userIsAdmin))
                                            && $offer->getPlatypus()->getSex() == "männlich"):
                                            echo "selected";
                                        endif;?>>Männlich</option>
                                        <option value="weiblich" <?php
                                        if(($isUpdate && ($userIsOwner || $userIsAdmin))
                                            && $offer->getPlatypus()->getSex() == "weiblich"):
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
                                if($isUpdate && ($userIsOwner || $userIsAdmin)):
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
                                if($isUpdate && ($userIsOwner || $userIsAdmin)):
                                    echo $offer->getPlatypus()->getSize();
                                endif;?>">
                                <p>cm</p>
                            </div>
                        </div>
                        <div class="attribute-item dropdown-item">
                            <div class="attribute-item-header dropdown-item-header">
                                <p>Gewicht</p>
                            </div>
                            <div class="attribute-item-select dropdown-item-select">
                                <label for="size" hidden>Gewicht</label>
                                <input type="number" id="weight" name="weight" min="0" max="3000" value="<?php
                                if($isUpdate && ($userIsOwner || $userIsAdmin)):
                                    echo $offer->getPlatypus()->getWeight();
                                endif;?>">
                                <p>g</p>
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
