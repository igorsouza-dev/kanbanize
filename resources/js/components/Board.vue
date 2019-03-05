<template>
    <div>
        <v-container fluid grid-list-xl>
            <v-layout row wrap>
                <v-flex d-flex md-1 v-for="column in columns" :key="column.id">
                    <v-card>
                        <v-card-title>
                            <h2>
                                {{ column.name }}
                            </h2>
                        </v-card-title>
                        <v-card-text>
                            <v-layout column>
                                <v-flex d-flex v-for="item in column.cards" :key="item.key">
                                    <card :card-data="item"></card>
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
        props:[ 'columns' ],
        components: {
            AppSectionLoader,
            card
        },
        data() {
            return {
                loader: true,
            }
        }

    }
</script>

<style scoped>

</style>
