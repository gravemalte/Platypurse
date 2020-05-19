<div class="main-page">
    <div class="container-chat clearfix">
        <div class="people-list" id="people-list">
            <div class="search">
                <input type="text" placeholder="search"/>
                <i class="fa fa-search"></i>
            </div>
            <ul class="chat-list">
                <li class="clearfix">
                    <div class="about">
                        <div class="name">Will Smith</div>
                        <div class="status">
                            <i class="fa fa-circle online"></i> online
                        </div>
                    </div>
                </li>

                <li class="clearfix">
                    <div class="about">
                        <div class="name">Jonson der Stein</div>
                        <div class="status">
                            <i class="fa fa-circle offline"></i> offline
                        </div>
                    </div>
                </li>

                <li class="clearfix">
                    <div class="about">
                        <div class="name">Tony Stark</div>
                        <div class="status">
                            <i class="fa fa-circle online"></i> online
                        </div>
                    </div>
                </li>

                <li class="clearfix">
                    <div class="about">
                        <div class="name">Hulk Hogan</div>
                        <div class="status">
                            <i class="fa fa-circle online"></i> online
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="chat">
            <div class="chat-header clearfix">

                <div class="chat-about">
                    <div class="chat-with">Chatten mit Will Smith</div>
                </div>
                <i class="fa fa-star"></i>
            </div> <!-- end chat-header -->

            <div class="chat-history">
                <ul>
                    <li class="chat-list">
                        <div class="message-data">
                            <span class="message-data-name"><i class="fa fa-circle online"></i> Will Smith</span>
                            <span class="message-data-time">10:05, Heute</span>
                        </div>
                        <div class="message my-message">
                            Hey wie viel kostet das blaue Schnabeltier?
                        </div>
                    </li>

                    <li class="clearfix chat-list">
                        <div class="message-data align-right">
                            <span class="message-data-time">10:14, Heute</span> &nbsp; &nbsp;
                            <span class="message-data-name">Ich</span> <i class="fa fa-circle me"></i>
                        </div>
                        <div class="message other-message float-right">
                            Moin Will, danke für deine Anfrage, das Schanbeltier kostet 50€
                        </div>
                    </li>

                    <li class="chat-list">
                        <div class="message-data">
                            <span class="message-data-name"><i class="fa fa-circle online"></i> Will Smith</span>
                            <span class="message-data-time">10:20, Heute</span>
                        </div>
                        <div class="message my-message">
                            Cool, danke für deine Antwort. Ich nehme es!
                        </div>
                    </li>
                </ul>

            </div>

            <div class="chat-message clearfix">
                <textarea class="text-chat" name="message-to-send" id="message-to-send" placeholder="Gib bitte dein Nachricht ein..." rows="3"></textarea>
                <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
                <i class="fa fa-file-image-o"></i>
                <button class="button-send">Send</button>
            </div>
        </div>
    </div>

</div>
