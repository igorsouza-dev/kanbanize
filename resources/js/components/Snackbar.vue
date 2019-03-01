<template>
    <v-snackbar
            :timeout="timeout"
            top
            v-model="snack"
    >
        {{ this.text }}
        <v-btn
                color="pink"
                flat
                @click.native="snack=false"
        >
            Close
        </v-btn>
    </v-snackbar>
</template>

<script>
    export default {
        name: "Snackbar",
        props: ['text', 'showsnack'],
        data() {
            return {
                timeout: 2000,
                snack: false
            }
        },
        beforeMount() {
            this.snack = this.showsnack;
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
