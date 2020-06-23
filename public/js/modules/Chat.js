"use strict";

function buildChat(modules) {
    const ChatThreadList = modules.ChatThreadList;
    const ChatMessage = modules.ChatMessage;

    class Chat {
        constructor() {
            this.container = document.getElementById("chat-container");
            this.chatThreadList = new ChatThreadList;
            this.messages = [];
        }

        async fetchMessages() {
            let messageResponse = await fetch("./chat/getChatHistory");
            let messages = await messageResponse.json();
            for (let message of messages) {
                this.messages.push(new ChatMessage(message));
            }
            console.log(this.messages);
        }
    }

    return Chat;
}

export default buildChat;