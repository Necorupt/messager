<template>
    <h1 @click="test"> Hello world</h1>
</template>
<script>
export default {
    methods: {
        test() {
            alert('You clicked me!');
        }
    },
}
</script>

<style>
h1 {
    color: blue;
}
</style>