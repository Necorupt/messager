<template>
    <RouterLink :to="{ name: 'index' }">Main page</RouterLink>
    <h1>Chat {{ chat.name }}</h1>
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
            {{item}}
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
            members: null,
        }
    },
    mounted() {
        ApiService.setHeader();

        ApiService.get('/chat/' + this.$route.params.id).then((response) => {
            this.chat = response.data;
            this.getMembers();
        })
    },
    methods: {
        getMembers() {
            ApiService.get('/chat/' + this.$route.params.id + '/members').then((response) => {
                this.members = response.data;
            });
        },
        AddMember() {

        },
        sendMessage(){
            this.messages.push(this.newMessage);
            this.newMessage = '';
        }
    },
}

</script>

<style scoped>
.messages{
    padding-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    border: 1px solid black;
}

</style>