<template>
    <div>
        <toolbar :title="this.myBoard.name"
                 @newcard="dialog.show=true"
                 @refresh="getColumns"
        ></toolbar>
        <app-section-loader :status="loader"></app-section-loader>

        <board v-if="!loader" :columns="this.myBoard.columns"></board>
        <new-card-dialog :parent-board="this.myBoard" :dialog="dialog" @updateParent="getColumns" @close="closeDialog"></new-card-dialog>
    </div>
</template>

<script>
    import AppSectionLoader from "./AppSectionLoader";

    import Board from './Board';
    import axios from 'axios';
    import Toolbar from "./Toolbar";
    import NewCardDialog from "./NewCardDialog";
    export default {
        name: "Kanban",
        components:{
            Toolbar,
            Board,
            NewCardDialog,
            AppSectionLoader
        },
        props: ['board'],
        data() {
            return {
                columns: [],
                loaded: false,
                title: '',
                myBoard: this.board,
                column: null,
                description: '',
                dialog: {show: false},
                loader: false,
                progress: 25,
            }
        },
        methods: {
            getBoard() {
                axios.get('/api/boards/'+this.board).then(response => {
                    this.myBoard = response.data;
                    this.loaded = true;
                }).catch( error => {
                    this.loaded = true;
                });
            },
            getColumns() {
                this.loader = true;
                axios.get('/api/boards/'+this.board+'/columns').then(response => {
                    this.columns = response.data;
                    this.loader=false;
                }).catch(error => {
                    console.error(error);
                    this.loader=false;
                });
            },
            closeDialog() {
                this.dialog.show =false;
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
