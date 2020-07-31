"use strict";

// function to load the Chat module async
function buildChat(modules) {

    // modules used by this module
    const ChatThreadMap = modules.ChatThreadMap;
    const ChatMessage = modules.ChatMessage;
    const ChatThread = modules.ChatThread;

    class Chat {
        /**
         * Represents the Chat as a whole.
         */
        constructor() {
            /**
             * The HTML element that contains the chat.
             *
             * @type {HTMLElement}
             */
            this.container = document.getElementById("chat-container");

            /**
             * A map of all chat threads.
             *
             * @type {ChatThreadMap}
             */
            this.chatThreadMap = new ChatThreadMap;

            /**
             * The id of the currently chatting user.
             *
             * @type {string}
             */
            this.userId = document.getElementById("chat-user-id").innerHTML;

            /**
             * All messages the chat knows about.
             *
             * @type {ChatMessage[]}
             */
            this.messages = [];

            /**
             * The current thread by id.
             *
             * @type {?string}
             */
            this.currentThreadId = null;
        }

        /**
         * Returns the active thread or an empty one.
         *
         * @returns {ChatThread}
         */
        get currentThread() {
            if (!this.chatThreadMap.has(this.currentThreadId)) {
                return new ChatThread();
            }
            return this.chatThreadMap.get(this.currentThreadId);
        }

        /**
         * Fetches the full chat history.
         *
         * @returns {Promise<void>}
         */
        async fetchMessages() {
            // fetch all messages
            let messageResponse = await fetch("./chat/getChatHistory");

            // send the user to login if not authorized
            if (messageResponse.status === 401) {
                window.location.href = "./login";
                return;
            }

            let responseJson = await messageResponse.json();
            let messages = responseJson.chat;
            this.lastRequestDate = new Date(responseJson.date);

            // creates threads to store messages
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

            // wait until all chat threads are ready
            await Promise.all(nameLoader);
        }

        /**
         * Sets the thread list to the new values.
         */
        setThreads() {
            this.chatThreadMap.container.innerHTML = "";
            let chatInput = document.getElementById("chat-input");

            // sort threads by date of latest message
            let chatThreads = Array.from(this.chatThreadMap.values()).sort(ChatThread.compareDate);
            for (let chatThread of chatThreads) {
                let isSelected = chatThread.id === this.currentThreadId;
                this.chatThreadMap.container.appendChild(chatThread.createElement(isSelected));
            }

            // add event to switch to threads
            for (let thread of this.chatThreadMap.values()) {
                let chat = this;
                let threadElement = thread.getElement();
                threadElement.addEventListener("click", event => {
                    chat.currentThread.unselect();
                    thread.select();
                    chat.currentThreadId = thread.id;
                    this.setTitle();
                    this.setChatLog();

                    // highlight current thread
                    chatInput.select();
                });
            }
        }

        /**
         * Sets the title at the top of the chat.
         */
        setTitle() {
            let titleContainer = document.getElementById("chat-title-container");
            let titleLink = titleContainer.children[0];
            let titleName = titleLink.children[0];

            // if no chat is selected show an empty title
            if (this.currentThreadId === null) {
                titleLink.href = "";
                titleName.innerHTML = "&nbsp;";
                return;
            }

            titleLink.href = "profile?id=" + this.currentThreadId;
            titleName.innerHTML = this.currentThread.recipientName;
        }

        /**
         * Set the active chat log.
         */
        setChatLog() {
            let textContainer = document.getElementById("chat-text-container");
            textContainer.innerHTML = "";
            let thread = this.currentThread;
            for (let message of thread) {
                textContainer.appendChild(message.createElement(this.userId));
            }

            // always show newest message after receiving one
            textContainer.scrollBy(0, textContainer.offsetHeight);
        }

        /**
         * Initializes the chat.
         *
         * @returns {Promise<void>}
         */
        async init() {
            // get current thread
            const urlParams = new URLSearchParams(window.location.search);
            this.currentThreadId = urlParams.get('id');

            await this.fetchMessages();

            if (this.currentThreadId === this.userId) {
                window.location = "./chat";
                return;
            }

            // show current thread
            if (!this.chatThreadMap.has(this.currentThreadId) && this.currentThreadId !== null) {
                let recipientNameResponse = await fetch("./chat/getUserDisplayName?id=" + this.currentThreadId);
                let recipientName = await recipientNameResponse.text();
                let chatThread = new ChatThread(this.currentThreadId);
                chatThread.recipientName = recipientName;
                chatThread.id = this.currentThreadId;
                this.chatThreadMap.set(this.currentThreadId, chatThread);
            }

            // set chat displays
            this.setTitle();
            this.setChatLog();
            this.setThreads();

            let chatInputForm = document.getElementById("chat-input-form");
            let chatInput = document.getElementById("chat-input");
            let chatInputButton = document.getElementById("chat-input-fire");
            let chat = this;

            // sending a message
            async function submitMessage(event) {
                event.preventDefault();
                if (chatInput.value === "") return;
                let sendResponse = await chat.sendMessage(chatInput.value);
                chatInput.value = "";
            }

            // catch submit event
            chatInputForm.addEventListener("submit", event => submitMessage(event));

            // let the button submit the message
            chatInputButton.addEventListener("click", event => {
                submitMessage(new Event("submit"));
            });

            // update regularly the shown timestamps
            setInterval(this.updateTimeStamps, 3000, this);

            // finally display chat after all loaded
            this.container.classList.remove("hide");
            document.getElementById("load-container").style.display = "none";
            this.container.scrollIntoView({
                block: "start",
                behavior: "smooth"
            });

            // regularly fetch new messages
            await (async () => {
                const callFunction = () => {
                    const callNext = () => {
                        callFunction();
                    }
                    setTimeout(() => {
                        this.fetchNewMessages().then(callNext);
                    }, 3000);
                }
                callFunction();
            })();

            // highlight current thread
            chatInput.select();
        }

        /**
         * Sends a message to the server.
         *
         * @param {string} messageText
         * @returns {Promise<void|ChatMessage>}
         */
        async sendMessage(messageText) {
            if (this.currentThreadId === null) return;

            let payload = new URLSearchParams();
            payload.set("message", messageText);
            payload.set("to-id", this.currentThreadId);
            payload.set("csrf", document.getElementById("csrf-token").value);
            let sendMessageResponse = await fetch("./chat/sendMessage", {
                method: "POST",
                body: payload
            });

            // send the user to login if not authorized
            if (sendMessageResponse.status === 401) {
                window.location.href = "./login";
                return;
            }

            let sendMessage = await sendMessageResponse.json();
            return new ChatMessage(sendMessage);
        }

        /**
         * Fetch the new messages on the server.
         *
         * @returns {Promise<void>}
         */
        async fetchNewMessages() {
            let requestDate = getDatabaseString(this.lastRequestDate, true);
            let url = new URL("./chat/getNewMessages", window.location.toString());
            if (this.messages.length === 0) {
                url.searchParams.set("latest-id", 0);
            }
            else {
                url.searchParams.set("latest-id", this.messages[this.messages.length - 1].id);
            }

            // fetch new messages
            let messageResponse = await fetch(url.toString());

            // send the user to login if not authorized
            if (messageResponse.status === 401) {
                window.location.href = "./login";
                return;
            }

            let responseJson = await messageResponse.json();
            let messages = responseJson.chat;
            let messageAmount = this.messages.length;
            this.lastRequestDate = new Date(responseJson.date);

            let textContainer = document.getElementById("chat-text-container");

            // decide on actions of potentially new messages
            for (let message of messages) {

                // check if message is new
                let chatMessage = new ChatMessage(message);
                if (this.messages.length === 0) {
                    this.messages.push(chatMessage);
                }
                else if (parseInt(chatMessage.id) > parseInt(this.messages[this.messages.length - 1].id)) {
                    this.messages.push(chatMessage);
                }

                // update chat and threads with new message
                let recipientId = chatMessage.senderId;
                if (recipientId === this.userId) recipientId = chatMessage.receiverId;
                if (!this.chatThreadMap.has(recipientId)) {
                    this.chatThreadMap.set(recipientId, new ChatThread(recipientId));
                }
                let hasUpdated = this.chatThreadMap.get(recipientId).update(chatMessage);
                if (recipientId === this.currentThreadId && hasUpdated) {
                    // display new message
                    textContainer.appendChild(chatMessage.createElement(this.userId));
                    textContainer.scrollTo({
                        top: textContainer.offsetHeight,
                        behavior: "smooth"
                    });
                }
            }
            if (this.messages.length !== messageAmount) {
                // if there were new message update the chat threads
                this.setThreads();
            }
        }

        /**
         * Updates all seen timestamps of the chat.
         *
         * @param chat
         */
        updateTimeStamps(chat = this) {
            for (let message of chat.currentThread) {
                let element = document.getElementById("message-id-" + message.id);
                element.getElementsByTagName("P")[0].innerText = getNiceDate(message.sendDate, true);
            }

            // easy way to update chat threads
            // may update this to be more performant
            chat.setThreads();
        }

    }

    return Chat;
}

export default buildChat;