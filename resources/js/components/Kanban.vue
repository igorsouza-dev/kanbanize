<template>
    <div>
        <toolbar :title="this.myBoard.name"
                 @newcard="newCard"
                 @newcolumn="newColumn"
                 @refresh="getColumns"
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
        <app-section-loader :status="loader"></app-section-loader>

        <board v-if="!loader" :board="myBoard" @deleted="deleted" @moved="moved" @editCard="editCard"></board>
        <card-dialog :parent-board="myBoard" :dialog="dialog" @updateParent="getColumns" @close="closeDialog"></card-dialog>
        <column-dialog :parent-board="myBoard" :dialog="dialogColumn" @updateParent="getColumns" @close="closeDialogColumn"></column-dialog>
    </div>
</template>

<script>
    import AppSectionLoader from "./AppSectionLoader";

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
            AppSectionLoader,
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
            }
        },
        methods: {
            getBoard() {
                axios.get('/api/boards/get?id='+this.board).then(response => {
                    this.myBoard = response.data;
                    this.initializeCard();
                    this.initializeColumn();
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
            },
            closeDialog() {
                this.dialog.show =false;
                this.initializeCard();
            },
            closeDialogColumn() {
                this.dialogColumn.show = false;
            },
            deleted() {
                this.showSnack("Card excluído com sucesso");
                this.getColumns();
            },
            moved(message) {
                if(message) {
                    this.showSnack(message);
                }
                this.getColumns();

            },
            editCard(card) {
                this.myBoard.card = card;
                this.dialog.show=true;
            },
            newCard() {
                this.initializeCard();
                this.dialog.show=true;
            },
            newColumn() {
                this.initializeColumn();
                this.dialogColumn.show = true;
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
                    order_id: ''
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
            showSnack(text) {
                this.snackText = text;
                this.snack = true;
            }
        },
        mounted() {
            this.getBoard();
            this.getColumns();
        }
    }
</script>

<style scoped>

</style>
