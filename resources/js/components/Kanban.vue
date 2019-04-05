<template>
    <div>

        <toolbar :title="this.myBoard.name"
                 @newcard="newCard"
                 @newcolumn="newColumn"
                 @refresh="forceRefresh"
        ></toolbar>
        <v-snackbar
            :timeout="timeout"
            top
            v-model="snack"
        >
            {{ this.snackText }}
            <v-btn color="pink" flat @click.native="snack=false">
                Close
            </v-btn>
        </v-snackbar>
        <v-progress-linear :indeterminate="true" v-show="loader" color="blue" background></v-progress-linear>

        <v-fade-transition>
            <board  v-if="!loader" :board="myBoard" @moved="moved" @editCard="editCard" @editColumn="editColumn"></board>
        </v-fade-transition>

        <card-dialog :parent-board="myBoard" :dialog="dialog" @updateParent="updatedCard" @deletedCard="deletedCard" @close="closeDialog"></card-dialog>
        <column-dialog :parent-board="myBoard" :dialog="dialogColumn" @updateParent="updatedColumn" @deletedColumn="deletedColumn" @close="closeDialogColumn"></column-dialog>
    </div>
</template>

<script>
    import Board from './Board';
    import axios from 'axios';
    import Toolbar from "./Toolbar";
    import CardDialog from "./CardDialog";
    import ColumnDialog from "./ColumnDialog";
    export default {
        name: "Kanban",
        components:{
            Toolbar,
            Board,
            CardDialog,
            ColumnDialog
        },
        props: ['board'],
        data() {
            return {
                columns: [],
                loaded: false,
                title: '',
                myBoard: {id: this.board, card: {}, column: {}},
                column_id: null,
                description: '',
                dialog: {show: false},
                dialogColumn: {show: false},
                loader: false,
                timeout: 2000,
                snack: false,
                snackText: '',
                canRefresh: true,
                hasUpdates: false,
            }
        },
        methods: {
            getBoard() {
                axios.get('/api/boards/get?id='+this.board).then(response => {
                    this.myBoard = response.data;
                    this.initializeCard();
                    this.initializeColumn();
                    this.startFirebase();
                    this.loaded = true;
                }).catch( error => {
                    this.loaded = true;
                });
            },
            getColumns() {
                this.loader = true;
                axios.get('/api/boards/columns?id='+this.board).then(response => {
                    this.myBoard.columns = response.data;
                    this.loader=false;
                }).catch(error => {
                    console.error(error);
                    this.loader=false;
                });
                this.hasUpdates = false;
            },
            getUsers() {
                axios.get('/api/users/get').then(response => {
                    this.myBoard.users = response.data;
                }).catch(error => {
                    console.error(error.message);
                });
            },
            closeDialog() {
                this.dialog.show =false;
                this.canRefresh = true;
                this.initializeCard();
                if(this.hasUpdates) {
                    this.refresh();
                }
            },
            closeDialogColumn() {
                this.dialogColumn.show = false;
                this.canRefresh = true;
                if(this.hasUpdates) {
                    this.refresh();
                }
            },
            updatedCard() {
                this.updateFirebase();
            },
            updatedColumn() {
                this.updateFirebase();
            },
            deletedCard() {
                this.showSnack("Card excluído com sucesso");
                this.updateFirebase();
            },
            deletedColumn() {
                this.showSnack("Coluna excluída com sucesso");
                this.updateFirebase();
            },
            moved(message) {
                if(message) {
                    this.showSnack(message);
                    this.refresh();
                } else {
                    this.updateFirebase();
                }
            },
            editCard(card) {
                this.myBoard.card = card;
                this.dialog.show = true;
                this.canRefresh = false;
            },
            newCard() {
                this.initializeCard();
                this.dialog.show = true;
                this.canRefresh = false;
            },
            newColumn() {
                this.initializeColumn();
                this.dialogColumn.show = true;
                this.canRefresh = false;
            },
            editColumn(column) {
                this.myBoard.column = column;
                this.dialogColumn.show = true;
                this.canRefresh = false;
            },
            initializeCard() {
                this.myBoard.card = {
                    title: '',
                    description: '',
                    column_id: '',
                    size: '',
                    priority: '',
                    deadline: '',
                    user_id: 0,
                    type: '',
                    order_id: '',
                    tag: ''
                };
            },
            initializeColumn() {
                this.myBoard.column = {
                    board_id: this.board,
                    name: '',
                    board_position: '',
                    max_cards: ''
                };
            },
            refresh() {
                if(this.canRefresh) {
                    this.getColumns();
                }
            },
            showSnack(text) {
                this.snackText = text;
                this.snack = true;
            },
            startFirebase() {
                let _this = this;
                this.getColumns();
                this.$firebase.ref('board/'+this.board).set({
                    columns: this.myBoard.columns
                }, function(error) {
                    _this.$firebase.ref('board/'+_this.board).on('value', (snapshot) => {
                        _this.hasUpdates = true;
                        _this.refresh();
                    });
                });

            },
            forceRefresh() {
                this.getColumns();
                this.updateFirebase();
            },
            updateFirebase() {
                this.$firebase.ref('board/'+this.board).set({
                    columns: this.myBoard.columns
                });
            }
        },
        mounted() {
            this.getBoard();
            this.getUsers();
            // this.getColumns();
        }
    }
</script>

<style scoped>

</style>
