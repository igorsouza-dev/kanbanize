<template>
    <v-toolbar dark :color="getColor">
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
        props: ['title', 'toolbarData'],
        data() {
            return {
                color: 'primary'
            }
        },
        computed: {
            getColor() {
                this.color = this.toolbarData.expired ? 'red' : 'primary';
                return this.color;
            }
        }
    }
</script>

<style scoped>

</style>
