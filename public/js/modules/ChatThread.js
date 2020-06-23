"use strict";

function buildChatThread(modules) {

    class ChatThread extends Array {
        constructor() {
            super();
        }
    }

    return ChatThread;
}

export default buildChatThread;