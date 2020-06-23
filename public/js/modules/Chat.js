"use strict";

function buildChat(modules) {
    const ChatThreadMap = modules.ChatThreadMap;
    const ChatMessage = modules.ChatMessage;
    const ChatThread = modules.ChatThread;

    class Chat {
        constructor() {
            this.container = document.getElementById("chat-container");
            this.chatThreadMap = new ChatThreadMap;
            this.userId = document.getElementById("chat-user-id").innerHTML;
            this.messages = [];
        }

        async fetchMessages() {
            let messageResponse = await fetch("./chat/getChatHistory");
            let messages = await messageResponse.json();

            this.chatThreadMap = new ChatThreadMap;
            this.messages = [];
            let messageLoader = [];
            for (let message of messages) {
                let chatMessage = new ChatMessage(message);
                this.messages.push(chatMessage);

                let recipientId = chatMessage.senderId;
                if (recipientId === this.userId) recipientId = chatMessage.receiverId;
                if (!this.chatThreadMap.has(recipientId)) {
                    this.chatThreadMap.set(recipientId, new ChatThread());
                }

                let thread = this.chatThreadMap.get(recipientId);
                thread.push(chatMessage);

                if (typeof thread.recipientName === "undefined") {
                    thread.recipientName = "";
                    messageLoader.push((async () => {
                        let recipientNameResponse = await fetch("./chat/getUserDisplayName?id=" + recipientId);
                        thread.recipientName = await recipientNameResponse.text();
                    })());
                }
            }
            await Promise.all(messageLoader);
            console.log(this);
        }
    }

    return Chat;
}

export default buildChat;