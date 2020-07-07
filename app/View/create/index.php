<?php
use Controller\OfferController;

$currentUser = $_SESSION['currentUser'];
$isUpdate = isset($_GET['id']);
if($isUpdate) {
    $offerId = $_GET['id'];
    $offer = OfferController::getOffer($offerId);
    $userIsOwner = $currentUser->getId() == $offer->getUser()->getId();
    $userIsAdmin = $currentUser->isAdmin();
}

$showUpdateData = $isUpdate && ($userIsOwner || $userIsAdmin);
$showName = "";
$showPrice = "";
$showDescription = "";
$showSex = "";
$showAge = "";
$showSize = "";
$showWeight = "";
$showZipcode = "";
if ($showUpdateData) {
    $showName = $offer->getPlatypus()->getName();
    $showPrice = $offer->getPrice(false);
    $showDescription = $offer->getDescription();
    $showSex = $offer->getPlatypus()->getSex();
    $showAge = $offer->getPlatypus()->getAgeYears();
    $showSize = $offer->getPlatypus()->getSize();
    $showWeight = $offer->getPlatypus()->getWeight();
    $showZipcode = $offer->getZipcode();
}
?>

<main class="main-page">
    <div class="main-area">
        <div class="create-offer-container card">
            <form action="create/processInput" method="post" data-needs-confirmation enctype="multipart/form-data">
            <?php if($showUpdateData):?>
                <input type="hidden" name="offerId" value='<?php echo $offer->getId();?>'>
            <?php endif;?>
                <div class="main-container">
                    <div class="name-container main-input-container">
                        <p class="name">Name</p>
                        <div class="input-container">
                            <label for="name">
                                <input
                                        type="text"
                                        placeholder="Name"
                                        id="name"
                                        name="name"
                                        required
                                        value="<?= $showName ?>"
                                >
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
                                        value="<?= $showPrice ?>"
                                >
                            </label>
                        </div>
                    </div>
                    <div class="img-container main-input-container">
                        <p class="name">Bilder</p>
                        <div class="drag-drop-container drop-files">
                            <input
                                    id="create-image"
                                    type="file"
                                    multiple
                                    accept="image/*"
                                    name="image"
                                    hidden
                            >
                            <label for="create-image">
                                <span>Drag'n'Drop</span>
                                <span>Bilder hier</span>
                                <span class="far fa-caret-square-down"></span>
                                <span>Oder hier klicken</span>
                                <span class="drop-files-show"></span>
                            </label>
                        </div>
                    </div>
                    <div class="description-container main-input-container">
                        <p class="name">Beschreibung</p>
                        <div class="input-container">
                            <label for="description">
                                <textarea
                                        placeholder="Beschreibung"
                                        id="description"
                                        name="description"
                                ><?= $showDescription?></textarea>
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
                                        if(($showUpdateData)
                                            && $showSex == "männlich"):
                                            echo "selected";
                                        endif;?>>Männlich</option>
                                        <option value="weiblich" <?php
                                        if(($showUpdateData)
                                            && $showSex == "weiblich"):
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
                                <input
                                        type="number"
                                        id="age"
                                        name="age"
                                        min="0"
                                        max="20"
                                        value="<?= $showAge ?>"
                                >
                                <p>Jahre</p>
                            </div>
                        </div>
                        <div class="attribute-item dropdown-item">
                            <div class="attribute-item-header dropdown-item-header">
                                <p>Körpergröße</p>
                            </div>
                            <div class="attribute-item-select dropdown-item-select">
                                <label for="size" hidden>Körpergröße</label>
                                <input
                                        type="number"
                                        id="size"
                                        name="size"
                                        min="0"
                                        max="75"
                                        value="<?= $showSize ?>">
                                <p>cm</p>
                            </div>
                        </div>
                        <div class="attribute-item dropdown-item">
                            <div class="attribute-item-header dropdown-item-header">
                                <p>Gewicht</p>
                            </div>
                            <div class="attribute-item-select dropdown-item-select">
                                <label for="weight" hidden>Gewicht</label>
                                <input
                                        type="number"
                                        id="weight"
                                        name="weight"
                                        min="0"
                                        max="3000"
                                        value="<?= $showWeight ?>"
                                >
                                <p>g</p>
                            </div>
                            <div class="attribute-item dropdown-item">
                                <div class="attribute-item-header dropdown-item-header">
                                    <p>Standort (Postleitzahl)</p>
                                </div>
                                <div class="attribute-item-select dropdown-item-select">
                                    <label for="zipcode" hidden>Postleitzahl</label>
                                    <input
                                            type="text"
                                            id="zipcode"
                                            name="zipcode"
                                            pattern="^([0]{1}[1-9]{1}|[1-9]{1}[0-9]{1})[0-9]{3}$"
                                            value="<?= $showZipcode ?>"
                                    >
                                    <p></p>
                                </div>
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
    <div class="confirm-changes-container-background" id="confirm-changes-container" hidden>
        <div>
            <div class="confirm-changes-container card">
                <?php if ($isUpdate): ?>
                <h2>Änderungen anwenden?</h2>
                <?php else: ?>
                <h2>Angebot so erstellen?</h2>
                <?php endif; ?>
                <div class="confirm-changes-diff-container" id="confirm-changes-diff">
                    <p
                            data-confirm-diff="name"
                            data-confirm-og-value="<?= $showName ?>"
                    >
                        <strong>Neuer Name:</strong>
                        <span data-confirm-new></span>
                        <?php if ($showUpdateData): ?>
                        (<?= $showName ?>)
                        <?php endif; ?>
                    </p>
                    <p
                            data-confirm-diff="price"
                            data-confirm-og-value="<?= $showPrice ?>"
                    >
                        <strong>Neuer Preis:</strong>
                        <span data-confirm-new></span>
                        <?php if ($showUpdateData): ?>
                        (<?= $showPrice ?>)
                        <?php endif; ?>
                    </p>
                    <p
                            data-confirm-diff="image"
                            data-confirm-og-value=""
                    >
                        <strong>Neue(s) Bild(er):</strong>
                        <span data-confirm-new></span>
                    </p>
                    <p
                            data-confirm-diff="description"
                            data-confirm-og-value="<?= $showDescription ?>"
                    >
                        <strong>Neue Beschreibung:</strong>
                        <span data-confirm-new></span>
                        <?php if ($showUpdateData): ?>
                        (<?= $showDescription ?>)
                        <?php endif; ?>
                    </p>
                    <p
                            data-confirm-diff="sex"
                            data-confirm-og-value="<?= $showSex ?>"
                    >
                        <strong>Neues Geschlecht:</strong>
                        <span data-confirm-new></span>
                        <?php if ($showUpdateData): ?>
                        (<?= $showSex ?>)
                        <?php endif; ?>
                    </p>
                    <p
                            data-confirm-diff="age"
                            data-confirm-og-value="<?= $showAge ?>"
                    >
                        <strong>Neues Alter:</strong>
                        <span data-confirm-new></span>
                        <?php if ($showUpdateData): ?>
                        (<?= $showAge ?>)
                        <?php endif; ?>
                    </p>
                    <p
                            data-confirm-diff="size"
                            data-confirm-og-value="<?= $showSize ?>"
                    >
                        <strong>Neue Größe:</strong>
                        <span data-confirm-new></span>
                        <?php if ($showUpdateData): ?>
                        (<?= $showSize ?>)
                        <?php endif; ?>
                    </p>
                    <p
                            data-confirm-diff="weight"
                            data-confirm-og-value="<?= $showWeight ?>"
                    >
                        <strong>Neues Gewicht:</strong>
                        <span data-confirm-new></span>
                        <?php if ($showUpdateData): ?>
                        (<?= $showWeight ?>)
                        <?php endif; ?>
                    </p>
                    <p
                            data-confirm-diff="zipcode"
                            data-confirm-og-value="<?= $showZipcode ?>"
                    >
                        <strong>Neuer Standort:</strong>
                        <span data-confirm-new></span>
                        <?php if ($showUpdateData): ?>
                            (<?= $showZipcode ?>)
                        <?php endif; ?>
                    </p>
                </div>
                <button title="Änderungen anwenden" data-confirm="confirm">
                    <span class="fas fa-check-double"></span>
                </button>
                <button title="Abbrechen" data-confirm="cancel">
                    <span class="fas fa-times"></span>
                </button>
            </div>
        </div>
    </div>
</main>
