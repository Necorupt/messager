<template>
    <header>
        <div class="menu__left">
            <MenuIcon @click="switchNavigation" class="menu__icon" />
            <h3>{{ currentChat.name }}</h3>
        </div>
    </header>

    <div :class="['header__navigation', isNavigationVisible ? 'header__navigation-visible' : '']">
        <CloseIcon @click="switchNavigation" class="navigation__close" />
        <div class="navigation__list">
            <h3>
                <RouterLink class="text__link" :to="{ name: 'index' }" @click="closeChat">Закрыть чат</RouterLink>
            </h3>
            <h3>Профиль</h3>
        </div>
        <div class="navigation__chat-list">
            <h3 v-for="chat in chats" :key="chat.id" :class="chat.id == currentChat.id ? 'navigation__chat-active ' : ''">
                <RouterLink @click="switchNavigation" :to="{ name: 'chat', params: { id: chat.id } }"
                    class="text__link navigation__chat">{{ chat.name }}</RouterLink>
            </h3>
        </div>
    </div>
</template>

<script>
import MenuIcon from "@/components/icons/MenuIcon.vue"
import CloseIcon from "@/components/icons/CloseIcon.vue"
import { mapGetters, mapActions } from "vuex";
import ApiService from '../services/ApiService';

export default {
    components: {
        MenuIcon,
        CloseIcon
    },
    data() {
        return {
            isNavigationVisible: false,
            chats: [{
                name: null,
                description: null,
                id: 0
            }],
        }
    },
    mounted() {
        ApiService.setHeader();
        ApiService.get('/chat').then((response) => {
            this.chats = response.data;
        })
    },
    computed: {
        ...mapGetters(['currentChat'])
    },
    methods: {
        ...mapActions(['clearCurrentChat']),
        switchNavigation() {
            this.isNavigationVisible = !this.isNavigationVisible;
        },
        closeChat() {
            this.isNavigationVisible = false;
            this.clearCurrentChat();
        }
    }
}

</script>

<style scoped>
header {
    position: relative;
    display: flex;
    width: calc(100% - 32px);
    background-color: #1b1d1a;
    height: 40px;
    justify-content: space-between;
    align-items: center;
    padding: 0 16px;
}

.menu__icon {
    height: 32px;
    fill: aliceblue;
}

.menu__left {
    display: flex;
    flex-direction: row;
    gap: 16px;
    align-items: center;

}

@keyframes show_navigation {
    from {
        transform: translateX(-300px);
    }

    to {
        transform: translateX(0px);
    }
}

@keyframes hide_navigation {
    to {
        transform: translateX(-300px);
    }

    from {
        transform: translateX(0px);
    }
}

.navigation__close {
    height: 32px;
    fill: aliceblue;
}

.header__navigation {
    position: absolute;
    display: flex;
    width: 300px;
    flex-direction: column;
    gap: 16px;
    transform: translateX(-300px);
    background-color: #1b1d1a;
    height: 100%;
}

.header__navigation-visible {
    transform: translateX(0px);
    animation-name: show_navigation;
    animation-duration: 0.5s;
    animation-timing-function: ease-in-out;
}

.navigation__list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 0 10px;
}

.navigation__chat-list{
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.navigation__chat-active {
    background-color: #574B60;
}

.navigation__chat{
    padding: 0 10px;
}
</style>