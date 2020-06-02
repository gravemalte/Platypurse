<body>
<nav>
    <div class="nav-container">
        <label for="expand-nav" hidden>Navigation ausklappen</label>
        <input type="checkbox" id="expand-nav" hidden checked>
        <label for="expand-nav" class="fas fa-bars"></label>
        <label for="expand-nav" class="fas fa-arrow-up"></label>
        <div class="nav-logo-container">
            <a href="/">
                <img src="assets/logo/svg/logo_text.svg" alt="show/hide menu button">
            </a>
        </div>
        <div class="nav-search-container">
            <form action="search" method="post">
                <label for="search" hidden>Suche</label>
                <input type="text" id="search" name="search" placeholder="Suche...">
                <label for="submit-search" hidden>Suche starten</label>
                <button id="submit-search" type="submit" hidden></button>
                <label for="submit-search" class="fas fa-search"></label>
            </form>
        </div>
        <div class="nav-buttons-container">
            <div class="nav-create-offer-container">
                <a href="create" class="button">Angebot erstellen</a>
            </div>
            <?php if(isset($_SESSION['user-email'])): ?>
            <div class="nav-logout-container">
                <a href="login/logout" class="button">Abmelden</a>
            </div>
            <?php else: ?>
            <div class="nav-login-container">
                <a href="login" class="button">Login</a>
            </div>
            <?php endif; ?>
        </div>
        <?php if(isset($_SESSION['user-email'])): ?>
        <!-- will be used when database integration is ready
        <div class="nav-profile-container">
            <a href="profile/<?php echo $_SESSION['user-id'] ?>"
               title="<?php echo $_SESSION['user-display-name'] ?>">
                <img src="assets/nav/user-circle-solid.svg" alt="user avatar">
            </a>
        </div>
        -->
        <div class="nav-profile-container">
            <a href="profile"
               title="Anzeigename">
                <img src="assets/nav/user-circle-solid.svg" alt="user avatar">
            </a>
        </div>
        <?php endif; ?>
    </div>
</nav>
