<template>
    LOGIN
    <form ref="form" @submit.prevent="login">
        <input type="text" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <button>Login</button>
    </form>
</template>

<script>
import { mapActions } from 'vuex/dist/vuex.cjs.js';


export default {
    methods: {
        ...mapActions({ storeLogin: 'login' }),

        login() {
            this.storeLogin(this.$refs.form).then((e)=>{
                this.$router.push({name: 'index'});
            });
        }
    },
}

</script>