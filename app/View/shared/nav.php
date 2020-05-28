<body>
<nav>
    <div class="nav-container">
        <div class="show-menu-container nav-element">
            <a href="">
                <img src="assets/nav/bars-solid.svg" alt="show/hide menu button">
            </a>
        </div>
        <div class="logo-container nav-element">
            <a href="/">
                <img src="assets/logo/svg/logo_text.svg" alt="logo with text">
            </a>
        </div>
        <div class="search-container nav-element">
            <form action="search">
                <div>
                    <label for="search">
                        <input type="text" id="search" placeholder="Suche..." title="Suche">
                    </label>
                    <a href="search">
                        <img src="assets/nav/search-solid.svg" alt="search button">
                    </a>
                </div>
            </form>
        </div>
        <div class="create-offer-container nav-element">
            <a href="create" class="button create-offer-button">
                <div>
                    <p>Angebot erstellen</p>
                </div>
            </a>
        </div>
        <?php if(isset($_SESSION['user-email'])):  ?>
            <p>Welcome <?php echo $_SESSION['user-email'] ?></p>
            <div class="login-container nav-element">
                    <a href="login/logout" class="button login-button">
                        <div>
                            <p>Abmelden</p>
                        </div>
                    </a>
                </div>
            <?php else: ?>
                <div class="login-container nav-element">
                    <a href="login" class="button login-button">
                        <div>
                            <p>Anmelden</p>
                        </div>
                    </a>
                </div>
        <?php endif; ?>
        <div class="user-profile-container nav-element" hidden>
            <a href="">
                <img src="assets/nav/user-circle-solid.svg" alt="user-profile-icon" class="user-profile-icon">
            </a>
        </div>
    </div>
</nav>
