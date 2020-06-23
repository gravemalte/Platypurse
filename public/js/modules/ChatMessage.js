"use strict";

function buildChatMessage(modules) {

    class ChatMessage {
        constructor(chatData) {
            this.senderId = chatData.sender_id;
            this.receiverId = chatData.receiver_id;
            this.message = chatData.message;
            this.sendDate = new Date(chatData.send_date);
        }
    }

    return ChatMessage;
}

export default buildChatMessage;