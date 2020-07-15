<?php

if(isset($_GET['url'])){
    $slashPos = strpos($_GET['url'], '/', 1);
    if ($slashPos) {
        $isSubPage = true;
    }
}
?>


<body>
<nav>
    <div class="nav-container">
        <label for="expand-nav" hidden>Navigation ausklappen</label>
        <input type="checkbox" id="expand-nav" hidden checked>
        <label for="expand-nav" class="fas fa-bars"></label>
        <label for="expand-nav" class="fas fa-times"></label>
        <div class="nav-logo-container">
            <a href="<?= URL ?>">
                <img src="<?= \Hydro\Helper\CacheBuster::serve('assets/logo/svg/logo_text.svg', $isSubPage) ?>" alt="show/hide menu button">
            </a>
        </div>
        <div class="nav-search-container">
            <form action="search" method="get">
                <label for="search" hidden>Suche</label>
                <?php
                $searchText = "";
                if(isset($_GET['search'])):
                    $searchText = "value = '".htmlspecialchars(strip_tags($_GET['search']))."'";
                endif;?>
                <input type="text" id="search" <?= $searchText ?> name="search" placeholder="Suche...">
                <label for="submit-search" hidden>Suche starten</label>
                <button id="submit-search" type="submit" hidden></button>
                <label for="submit-search" class="fas fa-search"></label>
            </form>
        </div>
        <div class="nav-buttons-container">
            <div class="nav-create-offer-container">
                <a href="<?=URL . 'create' ?>" class="button">Angebot<br>erstellen</a>
            </div>
            <?php
            if(isset($_SESSION['currentUser'])):?>
            <div class="nav-logout-container">
                <a href="<?=URL . 'login/logout'?>" class="button">Abmelden</a>
            </div>
            <?php else:?>
            <div class="nav-login-container">
                <a href="<?=URL . 'login'?>" class="button">Login</a>
            </div>
            <?php endif; ?>
        </div>
        <?php if(isset($_SESSION['currentUser'])): ?>
        <div class="nav-profile-container">
            <a href="profile"
               title="<?= $_SESSION['currentUser']->getDisplayName() ?>">
                <img src="<?=  \Hydro\Helper\CacheBuster::serve($_SESSION['currentUser']->getPicture()) ?>" alt="user avatar">
            </a>
        </div>
        <?php endif; ?>
    </div>
</nav>
<?php if (isset($_SESSION['currentUser'])) if ($_SESSION['currentUser']->isAdmin()): ?>
<div class="nav-notification-container nav-admin-container">
    <p>Achtung!</p>
    <p>Du bist als Admin angemeldet.</p>
</div>
<?php endif; ?>
