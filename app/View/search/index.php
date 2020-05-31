<?php use Controller\OfferGridController; ?>

<div class="main-page filter-page">
    <div class="filter-area">
        <div class="filter-container card">
            <div class="title-container">
                <p>Filter</p>
            </div>
            <div class="filter-option">
                <div class="filter-option-header">
                    <p>Filteroption 1</p>
                </div>
                <div class="filter-option-dropdown">
                    <select id="filter-dropdown-1">
                        <option value="option-1-1">Option 1</option>
                        <option value="option-1-2">Option 2</option>
                        <option value="option-1-3">Option 3</option>
                    </select>
                </div>
            </div>
            <div class="filter-option">
                <div class="filter-option-header">
                    <p>Filteroption 3</p>
                </div>
                <div class="filter-option-dropdown">
                    <select id="filter-dropdown-2">
                        <option value="option-2-1">Option 1</option>
                        <option value="option-2-2">Option 2</option>
                        <option value="option-2-3">Option 3</option>
                    </select>
                </div>
            </div>
            <div class="filter-option">
                <div class="filter-option-header">
                    <p>Filteroption 2</p>
                </div>
                <div class="filter-option-dropdown">
                    <select id="filter-dropdown-3">
                        <option value="option-3-1">Option 1</option>
                        <option value="option-3-2">Option 2</option>
                        <option value="option-3-3">Option 3</option>
                    </select>
                </div>
            </div>
            <div class="filter-button-container">
                <div class="filter-button-reset">
                    <a href="" class="button reset-button">
                        <div>
                            <p>Zurücksetzen</p>
                        </div>
                    </a>
                </div>
                <div class="filter-button-search">
                    <a href="" class="button search-button">
                        <div>
                            <p>Suchen</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-area">
        <div class="search-results-container">
            <div class="offer-list-container">
                <?php echo OfferGridController::getDataAsGrid($_POST['search'])?>
                <!--<a class="offer-list-link" href="offer">
                    <div class="offer-list-item card">
                        <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="">
                        <p class="name">Smol Boi</p>
                        <p class="description">Total der süße, kleine Boi</p>
                        <div class="price-tag-container">
                            <p class="price-tag">22</p>
                        </div>
                    </div>
                </a>
                <a class="offer-list-link" href="offer">
                    <div class="offer-list-item card">
                        <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="">
                        <p class="name">Smol Boi</p>
                        <p class="description">Total der süße, kleine Boi</p>
                        <div class="price-tag-container">
                            <p class="price-tag">23</p>
                        </div>
                    </div>
                </a>
                <a class="offer-list-link" href="offer">
                    <div class="offer-list-item card">
                        <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="">
                        <p class="name">Smol Boi</p>
                        <p class="description">Total der süße, kleine Boi</p>
                        <div class="price-tag-container">
                            <p class="price-tag">22</p>
                        </div>
                    </div>
                </a>
                <a class="offer-list-link" href="offer">
                    <div class="offer-list-item card">
                        <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="">
                        <p class="name">Smol Boi</p>
                        <p class="description">Total der süße, kleine Boi</p>
                        <div class="price-tag-container">
                            <p class="price-tag">22</p>
                        </div>
                    </div>
                </a>
                <a class="offer-list-link" href="offer">
                    <div class="offer-list-item card">
                        <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="">
                        <p class="name">Smol Boi</p>
                        <p class="description">Total der süße, kleine Boi</p>
                        <div class="price-tag-container">
                            <p class="price-tag">22</p>
                        </div>
                    </div>
                </a>
                <a class="offer-list-link" href="offer">
                    <div class="offer-list-item card">
                        <img src="https://i.pinimg.com/originals/85/89/f4/8589f4a07642a1c7bbe669c2b49b4a64.jpg" alt="">
                        <p class="name">Smol Boi</p>
                        <p class="description">Total der süße, kleine Boi</p>
                        <div class="price-tag-container">
                            <p class="price-tag">22</p>
                        </div>
                    </div>
                </a>-->
            </div>
        </div>
    </div>
</div>