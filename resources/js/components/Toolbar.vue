<template>
    <v-toolbar dark color="primary">
        <v-toolbar-side-icon></v-toolbar-side-icon>

        <v-toolbar-title class="white--text">{{this.title}}</v-toolbar-title>

        <v-spacer></v-spacer>
        <v-btn icon @click="$emit('newcolumn')">
            <v-icon>note_add</v-icon>
        </v-btn>
        <v-btn icon @click="$emit('newcard')">
            <v-icon>queue</v-icon>
        </v-btn>

        <v-btn icon @click="$emit('refresh')">
            <v-icon>refresh</v-icon>
        </v-btn>
    </v-toolbar>
</template>

<script>
    export default {
        name: "Toolbar",
        props: ['title'],
        data() {
            return {
            }
        }
    }
</script>

<style scoped>

</style>
