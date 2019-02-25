<template>
    <div>
        <v-container fluid grid-list-xl>
            <v-layout row wrap>
                <v-flex d-flex md-1 v-for="column in columns" :key="column.id">
                    <v-flex d-flex>
                        <v-sheet
                            elevation="4"
                            class="d-flex"
                            color="green lighten-3"
                            height="50"
                            width="50"
                            max-width="50"
                        >
                            <card :title="column.name"></card>
                        </v-sheet>
                    </v-flex>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import card from './Card';
    export default {
        name: "Board",
        props:[ 'columns' ],
        components: {
            card
        }

    }
</script>

<style scoped>

</style>
