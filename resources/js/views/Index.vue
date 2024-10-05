<template>

    <ul v-if="!isAuth">
        <li>
            <router-link :to="{ name: 'login' }">Login</router-link>
        </li>
        <li>
            <router-link :to="{ name: 'register' }">Register</router-link>
        </li>
    </ul>
    <div v-else>
        <div class="chat-list">
            <div v-for="item in chats" class="chat__item">
                <h3>name: {{ item.name }}</h3>
                <p>description: {{ item.description }}</p>
                <router-link :to="{ name: 'chat', params: { id: item.id } }">go</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import ApiService from '../services/ApiService';

export default {
    data() {
        return {
            chats: [{
                name: null,
                description: null,
                id: 0
            }
            ],
        }
    },
    mounted() {
        ApiService.setHeader();
        ApiService.get('/chat').then((response) => {
            this.chats = response.data;
        })
    },
    computed: {
        ...mapGetters(['isAuth', 'auth']),
    },
    methods: {
        ...mapActions(['logout']),
        logout() {
            this.$store.dispatch('logout');
        }
    }
}

</script>