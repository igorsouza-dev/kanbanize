<template>
    <v-card color="purple" dark>
        <v-card-title primary class="title">{{cardData.title}}</v-card-title>
        <v-card-text>{{ cardData.description }}</v-card-text>
    </v-card>
</template>

<script>
    export default {
        name: "Card",
        props:['cardData'],
        data: () => ({
        })
    }
</script>

<style scoped>

</style>
