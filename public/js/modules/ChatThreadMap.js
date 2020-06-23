"use strict";

function buildChatThreadMap(modules) {
    const ChatThread = modules.ChatThread;

    class ChatThreadMap extends Map {
        constructor(threads) {
            super();
            this._container = document.getElementById("chat-list-container");
        }
    }

    return ChatThreadMap;
}

export default buildChatThreadMap;