<template>
    <div>
        <v-container grid-list-xs fluid align-center>
            <v-layout row wrap>
                <draggable v-model="columns"
                           direction="horizontal"
                           @change="onDragColumn"
                           ghostClass="dragGhost"
                           class="dragArea dragAreaColumns"
                           group="{'columns'}"
                           handle=".column-header"
                           draggable=".column-drag">
                    <v-flex d-flex lg3 md3 xs12 align-center v-for="column in columns" :key="column.id" class="column-drag">
                            <v-card max-width="250" >
                                <v-card-text>
                                    <div>
                                        <v-card color="accent" dark class="column-header">
                                            <v-card-text >
                                                <v-layout row style="padding: 0;">
                                                    <v-flex xs11 md11>
                                                        <h5>
                                                            {{ column.name }} ({{ column.cards.length }}/{{column.max_cards}})
                                                        </h5>
                                                    </v-flex>
                                                    <v-flex xs1 md1>
                                                        <v-btn flat icon class="very-small" @click="editColumn(column)">
                                                            <v-icon small>edit</v-icon>
                                                        </v-btn>
                                                    </v-flex>
                                                </v-layout>

                                            </v-card-text>
                                        </v-card>
                                    </div>
                                    <v-divider></v-divider>
                                    <v-layout column >
                                        <draggable v-model="column.cards" class="dragArea dragAreaCards" group="{'kanban'}"
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
                    </draggable>
                </v-layout>
        </v-container>
    </div>
</template>

<script>
    import card from './Card';
    import draggable from 'vuedraggable';
    import axios from 'axios';
    export default {
        name: "Board",
        props:[ 'board' ],
        components: {
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
            moved(error) {
                this.$emit('moved', error);
            },
            editCard(card) {
                this.$emit('editCard', card);
            },
            editColumn(column) {
                this.$emit('editColumn', column);
            },
            deleteColumn(column) {
                axios.delete('/columns/'+column.id).
                then(response => {
                    this.$emit('deletedColumn');
                }).catch(error => {

                });
            },
            onDragColumn(evt) {
                if(evt.moved) {
                    let id = evt.moved.element.id;
                    let pos = evt.moved.newIndex;
                    this.moveColumn(id, pos);
                }
            },
            moveColumn(id, pos) {
                axios.get('/api/columns/move/id/'+id+'?pos='+pos).
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
                axios.get('/api/cards/move/id/'+id+'?columnId='+column+'&pos='+pos).
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

    .dragAreaColumns{
        width: 100%;
        display: flex;
    }
    .dragAreaCards{
        min-height: 500px;
        max-height: 500px;
        overflow-y: auto;
    }
    .column-header{
        cursor: cell;
    }
    .dragGhost{
        border: solid grey 2px;
        opacity: 0.5;
    }
    .very-small {
        height: 16px !important;
        width: 16px !important;
    }

</style>
