<template>
    <div>
        <toolbar :title="this.board.name"></toolbar>
        <board :columns="this.board.columns"></board>
        <snackbar :show="showSnack" :text="snackText" @close="closeSnack"></snackbar>
        <v-progress-linear :indeterminate="true" v-show="true"></v-progress-linear>
    </div>
</template>

<script>
    import board from './Board';
    import axios from 'axios';
    import Toolbar from "./Toolbar";
    import Snackbar from "./Snackbar";
    export default {
        name: "Kanban",
        components:{
            Snackbar,
            Toolbar,
            board
        },
        props: ['board'],
        data() {
            return {
                columns: [],
                loaded: false,
                snackText: 'Carregado com sucesso',
                snack: false,
            }
        },
        methods: {
            getBoard() {
                axios.get('/api/boards/'+this.board).then(response => {
                    this.board = response.data;
                    this.loaded = true;
                    this.showSnack();
                }).catch( error => {
                    this.loaded = true;
                    this.snackText = 'Ocorreu um erro ao buscar dados';
                    this.showSnack();
                });
            },
            getColumns() {
                axios.get('/api/boards/'+this.board+'/columns').then(response => {this.columns = response.data}).catch(error => console.error(error));
            },
            showSnack() {
                this.snack = true;
            },
            closeSnack() {
                this.snack = false;
            },
        },
        mounted() {
            this.getBoard();
            this.getColumns();
        }
    }
</script>

<style scoped>

</style>
