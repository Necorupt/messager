<template>
    <RouterLink :to="{ name: 'index' }">Main page</RouterLink>
    <h1>Chat {{ chat.name }}</h1>
    <h4>id: {{ chat.id }}</h4>
    <h4>description {{ chat.description }}</h4>
    <div>
        <ul>
            <li v-for="member in members" :key="member.id">
                <h4>name: {{ member.user.name }}</h4>
                <h4>role: {{ member.role_id }}</h4>
            </li>
        </ul>
    </div>
    <h1>Messages</h1>
    <div class="send-message">
        <input type="text" v-model="newMessage" placeholder="Enter your message" />
        <button @click="sendMessage">Send</button>
    </div>
    <div class="messages">
        <div v-for="item in messages" class="message">
            <h4 class="message_author">User: {{ item.user.name }}</h4>
            <h4 class="message__text">say: {{ item.message }}</h4>
        </div>
    </div>
</template>

<script>
import ApiService from "../services/ApiService";

export default {
    data() {
        return {
            chat: {
                name: null,
                description: null,
            },
            newMessage: '',
            messages: [],
            user: null,
            members: null,
        }
    },
    mounted() {
        ApiService.setHeader();

        ApiService.get('/chat/' + this.$route.params.id).then((response) => {
            this.chat = response.data;
            this.getMembers();
            this.getMessages();
            this.JoinChannel();
        })
    },
    methods: {
        getMembers() {
            ApiService.get('/chat/' + this.$route.params.id + '/members').then((response) => {
                this.members = response.data;
            });
        },
        JoinChannel() {
            const echo = window.Echo;
            ApiService.get('/user').then((response) => {
                let userID = response.data.id;
                echo.channel('chat.' + this.chat.id).listen('.CreateMessage' , (data) => {
                    this.getMessages();
                })
            });
        },
        sendMessage() {
            let params = {
                message: this.newMessage,
                chat_id: this.$route.params.id,
            }
            ApiService.post('/message', params).then((response) => {
                this.newMessage = '';
                this.getMessages();
            });
        },
        getMessages() {
            ApiService.get('/chat/' + this.$route.params.id + '/messages').then((response) => {
                this.messages = response.data;
            });
        },
    },
}

</script>

<style scoped>
.messages {
    padding-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    border: 1px solid black;
    padding-left: 10px;
}

.message {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.message_author {
    font-weight: bold;
    margin: 0;
}

.message__text {
    padding-left: 15px;
    line-height: 1.01em;
    margin: 0;
}
</style>