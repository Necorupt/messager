<template>
    <div class="chat">
        <div class="messages__list" ref="messageList">
            <div v-for="item in messages" :class="item.user.id === this.user.id ? 'owner__message' : 'message'" @contextmenu="onContextMenu">
                <h4 class="message_author">{{ item.user.name }}</h4>
                <h4 class="message__text">{{ item.message }}</h4>
            </div>
        </div>
        <div class="send__message">
            <input class="send__message-text" type="text" v-model="newMessage" @keyup="onKeyUp"
                placeholder="Enter your message" />
            <button @click="sendMessage">Send</button>
        </div>
    </div>
</template>

<script>
import ApiService from "../services/ApiService";
import { mapActions } from "vuex";

export default {
    data() {
        return {
            chat: {
                name: null,
                description: null,
            },
            newMessage: '',
            messages: [],
            user: {
                id: null,
                name: null,
            },
            members: null,
        }
    },
    mounted() {
        this.initializeChat();
    },
    watch: {
        $route(val) {
           this.initializeChat();
        },
    },
    methods: {
        ...mapActions(['updateChat']),
        initializeChat() {
            ApiService.setHeader();

            ApiService.get('/chat/' + this.$route.params.id).then((response) => {
                this.chat = response.data;
                this.updateChat(this.chat);
                this.getSelfInfo().then((data) => {
                    this.getMembers();
                    this.getMessages();
                    this.JoinChannel();
                    this.scrollToBottom();
                })
            })
        },
        getMembers() {
            ApiService.get('/chat/' + this.$route.params.id + '/members').then((response) => {
                this.members = response.data;
            });
        },
        async getSelfInfo() {
            return new Promise((resolve, reject) => {
                ApiService.get('/user').then((response) => {
                    this.user = response.data;
                    resolve(response.data);
                }).catch((error) => {
                    reject(error);
                });
            });
        },
        JoinChannel() {
            const echo = window.Echo;
            echo.channel('chat.' + this.chat.id).listen('.CreateMessage', (data) => {
                this.messages.push(data.message);
            })
        },
        sendMessage() {
            let params = {
                message: this.newMessage,
                chat_id: this.$route.params.id,
            }
            this.scrollToBottom();
            ApiService.post('/message', params).then((response) => {
                this.newMessage = '';
                this.messages.push(response.data);
            });
        },
        onKeyUp(event) {
            if (event.key == 'Enter' && event.shiftKey === false) {
                this.sendMessage();
            }
            else if (event.key == 'Enter' && event.shiftKey === true) {
                this.newMessage += '\n';
            }
        },
        getMessages() {
            ApiService.get('/chat/' + this.$route.params.id + '/messages').then((response) => {
                let data = response.data;
                this.messages = data.data;
                this.nextMessages = data.next_page_url;
            });
        },
        onContextMenu(event){
            console.error(event);
        },
        scrollToBottom() {
        }
    },
}

</script>

<style scoped>
.chat {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: calc(100vh - 40px);
}

.messages__list {
    padding: 0 24px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    overflow: scroll;
    overflow-x: hidden;
    height: 100%;
}

.messages__list::-webkit-scrollbar {
    display: none;
}

.owner__message,
.message {
    display: flex;
    flex-direction: column;
    gap: 4px;
    width: 40%;
    border-radius: 4px;
    padding: 6px 6px;
}

.owner__message {
    background-color: #574B60;
    align-self: flex-end;
}

.message {
    background-color: #7D8491;
}

.message_author {
    font-weight: bold;
    margin: 0;
}

.send__message {
    display: flex;
    background-color: #10110f;
}

.send__message-text {
    width: 100%;
    height: 30px;
}

.message__text {
    line-height: 1.01em;
    margin: 0;
}
</style>