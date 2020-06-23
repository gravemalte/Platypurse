"use strict";

function buildChatThreadList(modules) {

    class ChatThreadList {
        constructor() {
            this._container = document.getElementById("chat-list-container");
        }
    }

    return ChatThreadList;
}

export default buildChatThreadList;