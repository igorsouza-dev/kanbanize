<template>
    <div>
        <toolbar :title="this.myBoard.name"
                 @newcard="newCard"
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
    </div>
</template>

<script>
    import AppSectionLoader from "./AppSectionLoader";

    import Board from './Board';
    import axios from 'axios';
    import Toolbar from "./Toolbar";
    import CardDialog from "./CardDialog";
    export default {
        name: "Kanban",
        components:{
            Toolbar,
            Board,
            CardDialog,
            AppSectionLoader
        },
        props: ['board'],
        data() {
            return {
                columns: [],
                loaded: false,
                title: '',
                myBoard: {id: this.board, card: {}},
                column_id: null,
                description: '',
                dialog: {show: false},
                loader: false,
                timeout: 2000,
                snack: false,
                snackText: '',
            }
        },
        methods: {
            getBoard() {
                axios.get('/api/boards/'+this.board).then(response => {
                    this.myBoard = response.data;
                    this.initializeCard();
                    this.loaded = true;
                }).catch( error => {
                    this.loaded = true;
                });
            },
            getColumns() {
                this.loader = true;
                axios.get('/api/boards/'+this.board+'/columns').then(response => {
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
            showSnack(text) {
                this.snackText = text;
                this.snack = true;
            }
        },
        mounted() {
            this.getBoard();
            this.initializeCard();
            this.getColumns();
        }
    }
</script>

<style scoped>

</style>
