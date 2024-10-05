<template>
    <router-view></router-view>
</template>

<script>
import { mapActions } from "vuex";
import ApiService from '../services/ApiService';

export default {
    mounted() {
        this.getAuth();
        ApiService.setHeader();
    },
    methods: {
        ...mapActions(['getAuth'])
    },
};

</script>