<?php
use Controller\ChatController;


$user = $_SESSION['currentUser'];
$userID = $user->getId();

if(isset($_GET['id'])){
    $to = $_GET['id'];
}


?>
<main class="main-page">
    <div class="chat-container card" id="chat-container">
        <span id="chat-user-id" hidden><?= $userID ?></span>
        <div class="chat-list-container" id="chat-list-container">
            <div>
                <div class="chat-contact-container select">
                    <div class="chat-contact-icon-container">
                        <img src="assets/nav/user-circle-solid.svg" alt="user icon">
                    </div>
                    <div class="chat-contact-text-container">
                        <h1>SchnabelFan1</h1>
                        <p>Nice!</p>
                    </div>
                    <p>Heute</p>
                    <div class="unread-messages-container" hidden>
                        <p>12</p>
                    </div>
                </div>
            </div>
            <div>
                <div class="chat-contact-container">
                    <div class="chat-contact-icon-container">
                        <img src="assets/nav/user-circle-solid.svg" alt="user icon">
                    </div>
                    <div class="chat-contact-text-container">
                        <h1>Perry</h1>
                        <p>Bruh!</p>
                    </div>
                    <p>18.05.</p>
                    <div class="unread-messages-container">
                        <p>12</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-main-container">
            <div class="chat-title-container" id="chat-title-container">
                <a href="profile">
                    <p>SchnabelFan1</p>
                </a>
            </div>
            <div class="chat-text-container" id="chat-text-container">
                <div class="chat-message-container receive">
                    <div>
                        <h1>Hey, ich fand dein Schnabeltier voll cute und so</h1>
                        <p>17:18</p>
                    </div>
                </div>
                <div class="chat-message-container send">
                    <div>
                        <h1>Nice!</h1>
                        <p>17:35</p>
                    </div>
                </div>
            </div>
            <div class="chat-send-container">
                <form action="chat" id="chat-input-form">
                    <div class="chat-input-container">
                        <label for="chat-input">
                            <input type="text" placeholder="Nachricht senden..." id="chat-input" title="Nachricht senden">
                        </label>
                        <p>
                            <span class="fas fa-location-arrow" id="chat-input-fire"></span>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>