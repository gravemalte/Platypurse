"use strict";

function buildChat(modules) {
    const ChatThreadMap = modules.ChatThreadMap;
    const ChatMessage = modules.ChatMessage;
    const ChatThread = modules.ChatThread;
    const NiceDate = modules.NiceDate;

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
            let responseJson = await messageResponse.json();
            let messages = responseJson.chat;
            this.lastRequestDate = new Date(responseJson.date);

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
            let chatInput = document.getElementById("chat-input");

            let chatThreads = Array.from(this.chatThreadMap.values()).sort(ChatThread.compareDate);
            for (let chatThread of chatThreads) {
                let isSelected = chatThread.id === this.currentThreadId;
                this.chatThreadMap.container.appendChild(chatThread.createElement(isSelected));
            }

            for (let thread of this.chatThreadMap.values()) {
                let chat = this;
                let threadElement = thread.getElement();
                threadElement.addEventListener("click", event => {
                    chat.currentThread.unselect();
                    thread.select();
                    chat.currentThreadId = thread.id;
                    this.setTitle();
                    this.setChatLog();

                    chatInput.focus();
                    chatInput.select();
                });
            }

            chatInput.focus();
            chatInput.select();
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
            textContainer.scrollBy(0, textContainer.offsetHeight);
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

            this.setTitle();
            this.setChatLog();
            this.setThreads();

            let chatInputForm = document.getElementById("chat-input-form");
            let chatInput = document.getElementById("chat-input");
            let chatInputButton = document.getElementById("chat-input-fire");
            chatInputForm.addEventListener("submit", event => {
                event.preventDefault();
                if (chatInput.value === "") return;
                this.sendMessage(chatInput.value);
                chatInput.value = "";
            });
            chatInputButton.addEventListener("click", event => {
                chatInputForm.dispatchEvent(new Event("submit"));
            });

            await (async () => {
                const callFunction = () => {
                    const callNext = () => {
                        callFunction();
                    }
                    setTimeout(() => {
                        this.fetchNewMessages().then(callNext);
                    }, 1000);
                }
                callFunction();
            })();
        }

        async sendMessage(messageText) {
            let payload = new URLSearchParams();
            payload.set("message", messageText);
            payload.set("to-id", this.currentThreadId);
            let sendMessageResponse = await fetch("./chat/sendMessage", {
                method: "POST",
                body: payload
            });
            console.log(sendMessageResponse);
            let sendMessage = await sendMessageResponse.json();
            console.log(sendMessage);
        }

        async fetchNewMessages() {
            let requestDate = (new NiceDate(this.lastRequestDate)).getDatabaseString();
            let url = new URL("/chat/getNewMessages", window.location.toString());
            url.searchParams.set("date", requestDate);

            let messageResponse = await fetch(url.toString());
            let responseJson = await messageResponse.json();
            let messages = responseJson.chat;
            let messageAmount = this.messages.length;
            this.lastRequestDate = new Date(responseJson.date);

            let textContainer = document.getElementById("chat-text-container");

            for (let message of messages) {
                let chatMessage = new ChatMessage(message);
                if (parseInt(chatMessage.id) > parseInt(this.messages[this.messages.length - 1].id)) {
                    this.messages.push(chatMessage);
                }

                let recipientId = chatMessage.senderId;
                if (recipientId === this.userId) recipientId = chatMessage.receiverId;
                if (!this.chatThreadMap.has(recipientId)) {
                    this.chatThreadMap.set(recipientId, new ChatThread(recipientId));
                }
                let hasUpdated = this.chatThreadMap.get(recipientId).update(chatMessage);
                if (recipientId === this.currentThreadId && hasUpdated) {
                    textContainer.appendChild(chatMessage.createElement(this.userId));
                    textContainer.scrollTo({
                        top: textContainer.offsetHeight,
                        behavior: "smooth"
                    });
                }
            }
            if (this.messages.length !== messageAmount) {
                this.setThreads();
            }
        }
    }

    return Chat;
}

export default buildChat;