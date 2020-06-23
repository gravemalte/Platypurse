"use strict";

function buildChat(modules) {
    const ChatThreadList = modules.ChatThreadList;

    class Chat {
        constructor() {
            console.log(ChatThreadList);
        }
    }

    return Chat;
}

export default buildChat;