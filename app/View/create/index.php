<div class="main-page">
    <div class="main-area">
        <div class="create-offer-container card">
            <form action="/offer">
                <div class="main-container">
                    <div class="name-container main-input-container">
                        <p class="name">Name</p>
                        <div class="input-container">
                            <label for="name">
                                <input type="text" placeholder="Name" id="name">
                            </label>
                        </div>
                    </div>
                    <div class="img-container main-input-container">
                        <p class="name">Bilder</p>
                        <div class="drag-drop-container">
                            <p>
                                Drag'n'Drop<br>
                                Bilder hier<br>
                                <span class="far fa-caret-square-down"></span>
                            </p>
                            <label for="image">
                                <input type="file" multiple accept="image/*" id="image">
                            </label>
                        </div>
                    </div>
                    <div class="description-container main-input-container">
                        <p class="name">Beschreibung</p>
                        <div class="input-container">
                            <label for="description">
                                <textarea placeholder="Beschreibung" id="description"></textarea>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="side-container">
                    <div class="attribute-list dropdown-list">
                        <div class="attribute-item dropdown-item">
                            <div class="attribute-item-header dropdown-item-header">
                                <p>Option 1</p>
                            </div>
                            <div class="attribute-item-select dropdown-item-select">
                                <label for="option1">
                                    <select name="Option 1" id="option1">
                                        <option value="Wert 1">Wert 1</option>
                                        <option value="Wert 2">Wert 2</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="buttons-container">
                        <a href="/offer" class="done-button button">
                            <div>
                                <span class="fas fa-clipboard-check"></span>
                            </div>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>