<template>
    <div>
        <v-container grid-list-xs fluid>
            <v-layout row wrap>
                <v-flex d-flex md-2 v-for="column in columns" :key="column.id">
                    <v-card max-width="250" >
                        <v-card-text>
                            <div>
                                <v-card color="accent" dark >
                                    <v-card-text >
                                        <h4>
                                            {{ column.name }} ({{ column.cards.length }}/{{column.max_cards}})
                                        </h4>
                                    </v-card-text>
                                </v-card>
                            </div>
                            <v-divider></v-divider>
                            <v-layout column>
                                <v-flex d-flex v-for="item in column.cards" :key="item.key">
                                    <card :card-data="item" @deleted="deleted" @moved="moved"></card>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                    </v-card>

                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import card from './Card';
    import AppSectionLoader from "./AppSectionLoader";
    export default {
        name: "Board",
        props:[ 'board' ],
        components: {
            AppSectionLoader,
            card
        },
        data() {
            return {
                loader: true,
                columns: this.board.columns
            }
        },
        methods: {
            deleted() {
                this.$emit('deleted');
            },
            moved(error) {
                this.$emit('moved', error);
            }
        }

    }
</script>

<style scoped>

</style>
