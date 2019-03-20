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
                            <v-layout column >
                                <draggable v-model="column.cards" class="dragArea" group="{'kanban'}"
                                           @change="onDrag"
                                           :move="onMove"
                                           ghostClass="dragGhost"
                                           draggable=".item"
                                           :id="column.id"
                                >
                                    <v-flex d-flex v-for="item in column.cards" :key="item.id"

                                            class="item">
                                        <card :card-data="item" @deleted="deleted" @moved="moved" @editCard="editCard"></card>
                                    </v-flex>
                                </draggable>
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
    import draggable from 'vuedraggable';
    import axios from 'axios';
    export default {
        name: "Board",
        props:[ 'board' ],
        components: {
            AppSectionLoader,
            card,
            draggable,
        },
        data() {
            return {
                loader: true,
                columns: this.board.columns,
                currentColumn: 0,
            }
        },
        methods: {
            deleted() {
                this.$emit('deleted');
            },
            moved(error) {
                this.$emit('moved', error);
            },
            editCard(card) {
                this.$emit('editCard', card);
            },
            onDrag(evt){
                if(evt.added) {
                    let id = evt.added.element.id;
                    let pos = evt.added.newIndex;
                    this.moveCard(id, this.currentColumn, pos);
                }
                if(evt.moved) {
                    let id = evt.moved.element.id;
                    let pos = evt.moved.newIndex;
                    this.moveCard(id, this.currentColumn, pos);
                }
            },
            moveCard(id, column, pos) {
                axios.get('/api/cards/'+id+'/move-card/'+column+'/'+pos).
                then(response => {
                    if(response.data.status === true) {
                        this.$emit('moved');
                    } else {
                        this.$emit('moved', response.data.error);
                    }
                }).catch(error => {
                    this.$emit('moved', error.error);
                });
            },
            onMove(evt) {
                this.currentColumn = evt.to.id;
                return true;
            }
        }

    }
</script>

<style scoped>
    .dragArea{
        min-height: 800px;
        max-height: 800px;
        overflow-y: auto;
    }
    .dragGhost{
        border: solid grey 2px;
    }
</style>
