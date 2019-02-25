<template>
    <v-snackbar
            :timeout="timeout"
            top
            v-model="show"
    >
        {{ this.text }}
        <v-btn
                color="pink"
                flat
                @click="hideSnack"
        >
            Close
        </v-btn>
    </v-snackbar>
</template>

<script>
    export default {
        name: "Snackbar",
        props: ['text', 'show'],
        data() {
            return {
                timeout: 2000
            }
        },
        methods: {
            hideSnack() {
                this.$emit('close');
            }
        }
    }
</script>

<style scoped>

</style>