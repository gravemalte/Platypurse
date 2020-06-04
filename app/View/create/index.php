<?php
use Hydro\Helper\DataSerialize;
use Model\OfferModel; ?>
<main class="main-page">
    <div class="main-area">
        <div class="create-offer-container card">
            <?php if(isset($_GET['id'])):
                $offer = DataSerialize::unserializeData(OfferModel::getData($_GET['id']))[0]; ?>
            <form action="create/update" method="post">
                <input type="hidden" name="offerId" value='<?php echo $offer->getId();?>'>
            <?php else:
                $offer = new OfferModel();?>
            <form action="create/create" method="post">
                <?php endif;?>
                <div class="main-container">
                    <div class="name-container main-input-container">
                        <p class="name">Name</p>
                        <div class="input-container">
                            <label for="name">
                                <input type="text" placeholder="Name" id="name" name="name" value='<?php echo $offer->getTitle();?>'>
                            </label>
                        </div>
                    </div>
                    <div class="name-container main-input-container">
                        <p class="name">Preis</p>
                        <div class="input-container">
                            <label for="price">
                                <input type="number" placeholder="Preis" id="price" name="price" value='<?php echo $offer->getPrice();?>'>
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
                                <textarea placeholder="Beschreibung" id="description" name="description"><?php echo $offer->getDescription();?></textarea>
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
                                        <option value="männlich" <?php if($offer->getSex() == "männlich"): echo "selected"; endif;?>>Männlich</option>
                                        <option value="weiblich" <?php if($offer->getSex() == "weiblich"): echo "selected"; endif;?>>Weiblich</option>
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
                                <input type="number" id="age" name="age" min="0" max="20" value="<?php echo $offer->getAge();?>">
                                <p>Jahre</p>
                            </div>
                        </div>
                        <div class="attribute-item dropdown-item">
                            <div class="attribute-item-header dropdown-item-header">
                                <p>Körpergröße</p>
                            </div>
                            <div class="attribute-item-select dropdown-item-select">
                                <label for="size" hidden>Körpergröße</label>
                                <input type="number" id="size" name="size" min="0" max="75" value="<?php echo $offer->getSize();?>">
                                <p>cm</p>
                            </div>
                        </div>
                    </div>
                    <div class="buttons-container">
                        <button type="submit" hidden id="create-submit"></button>
                        <label for="create-submit" class="fas fa-clipboard-check"
                               title="
                               <?php if(isset($_GET['id'])): ?>
                               Angebot anpassen
                               <?php else: ?>
                               Angebot erstellen
                               <?php endif; ?>
                               "
                        ></label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>