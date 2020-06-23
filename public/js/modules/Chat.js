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
            this.currentThreadId = null;
        }

        get currentThread() {
            return this.chatThreadMap.get(this.currentThreadId);
        }

        async fetchMessages() {
            let messageResponse = await fetch("./chat/getChatHistory");
            let messages = await messageResponse.json();

            this.chatThreadMap = new ChatThreadMap;
            this.messages = [];
            let nameLoader = [];
            for (let message of messages) {
                let chatMessage = new ChatMessage(message);
                this.messages.push(chatMessage);

                let recipientId = chatMessage.senderId;
                if (recipientId === this.userId) recipientId = chatMessage.receiverId;
                if (!this.chatThreadMap.has(recipientId)) {
                    this.chatThreadMap.set(recipientId, new ChatThread(recipientId));
                }

                let thread = this.chatThreadMap.get(recipientId);
                thread.push(chatMessage);

                if (thread.recipientName === "") {
                    nameLoader.push((async () => {
                        let recipientNameResponse = await fetch("./chat/getUserDisplayName?id=" + recipientId);
                        thread.recipientName = await recipientNameResponse.text();
                    })());
                }
            }
            await Promise.all(nameLoader);
        }

        setThreads() {
            this.chatThreadMap.container.innerHTML = "";

            let chatThreads = Array.from(this.chatThreadMap.values()).sort(ChatThread.compareDate);
            for (let chatThread of chatThreads) {
                let isSelected = chatThread.id === this.currentThreadId;
                this.chatThreadMap.container.appendChild(chatThread.createElement(isSelected));
            }
        }

        setTitle() {
            let titleContainer = document.getElementById("chat-title-container");
            let titleLink = titleContainer.children[0];
            let titleName = titleLink.children[0];

            if (this.currentThreadId === null) {
                titleLink.href = "";
                titleName.innerHTML = "&nbsp;";
                return;
            }

            titleLink.href = "profile?id=" + this.currentThreadId;
            titleName.innerHTML = this.currentThread.recipientName;
        }

        setChatLog() {
            let textContainer = document.getElementById("chat-text-container");
            textContainer.innerHTML = "";
            if (this.currentThreadId === null) return;
            let thread = this.currentThread;
            for (let message of thread) {
                textContainer.appendChild(message.createElement(this.userId));
            }
        }

        async init() {
            const urlParams = new URLSearchParams(window.location.search);
            this.currentThreadId = urlParams.get('id');

            await this.fetchMessages();

            if (!this.chatThreadMap.has(this.currentThreadId)) {
                let recipientNameResponse = await fetch("./chat/getUserDisplayName?id=" + this.currentThreadId);
                let recipientName = await recipientNameResponse.text();
                let chatThread = new ChatThread();
                chatThread.recipientName = recipientName;
                chatThread.id = this.currentThreadId;
                this.chatThreadMap.set(this.currentThreadId, chatThread);
            }

            this.setThreads();
            this.setTitle();
            this.setChatLog();

            for (let thread of this.chatThreadMap.values()) {
                let chat = this;
                let threadElement = thread.getElement();
                threadElement.addEventListener("click", event => {
                    chat.currentThread.unselect();
                    thread.select();
                    chat.currentThreadId = thread.id;
                    this.setTitle();
                    this.setChatLog();
                });
            }
        }

        async sendMessage(messageText) {

        }
    }

    return Chat;
}

export default buildChat;