<template>

    <Header></Header>

    <AuthLayout v-if="isAuth"></AuthLayout>
    <GuestLayout v-else></GuestLayout>

</template>

<script>
import Header from "@/components/Header.vue";
import { mapGetters } from "vuex";
import GuestLayout from "./GuestLayout.vue";
import AuthLayout from "./AuthLayout.vue";

export default {
    components: {
        Header,
        AuthLayout,
        GuestLayout,
    },
    computed: {
        ...mapGetters(['auth', 'isAuth'])
    }
}

</script>
