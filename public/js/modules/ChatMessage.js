"use strict";

function buildChatMessage(modules) {
    const NiceDate = modules.NiceDate;

    class ChatMessage {
        constructor(chatData) {
            this.messageId = chatData.msg_id;
            this.senderId = chatData.sender_id;
            this.receiverId = chatData.receiver_id;
            this.message = chatData.message;
            this.sendDate = new Date(chatData.send_date);
        }

        get id() {
            return this.messageId;
        }

        createElement(currentUserId) {
            let messageContainer =
                document.createElement("DIV");
            messageContainer.classList.add("chat-message-container");
            messageContainer.id = "message-id-" + this.messageId;
            if (this.receiverId === currentUserId) {
                messageContainer.classList.add("receive");
            }
            else {
                messageContainer.classList.add("send");
            }

            let innerContainer =
                document.createElement("DIV");

            let message =
                document.createElement("H1");
            message.innerText = this.message;

            let date =
                document.createElement("P");
            date.innerHTML = new NiceDate(this.sendDate).getNiceDate();

            innerContainer.appendChild(message);
            innerContainer.appendChild(date);
            messageContainer.appendChild(innerContainer);

            return messageContainer;
        }
    }

    return ChatMessage;
}

export default buildChatMessage;