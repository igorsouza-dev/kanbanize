<template>
    <div>
        <toolbar :title="this.board.name"></toolbar>
        <board :columns="this.board.columns"></board>
        <v-progress-linear :indeterminate="true" v-show="true"></v-progress-linear>
        <v-btn @click="dialog=true">Show</v-btn>
            <v-dialog v-model="dialog" max-width="600">
                <v-card>
                    <v-card-title>
                        <span class="headline">New Card</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-form
                                ref="form"
                                v-model="valid"
                                lazy-validation
                            >
                                <v-layout wrap>
                                    <v-flex xs12 sm12 md12>
                                        <select class="form-control" >
                                            <option v-for="item in board.columns" :key="item.id" value="item.id">{{ item.name }}</option>
                                        </select>
                                    </v-flex>
                                </v-layout>
                                <v-layout>
                                    <v-flex xs12 sm12 md12>
                                        <v-text-field label="Title*" :rules="[v => !!v || 'The title is required']" required></v-text-field>
                                    </v-flex>
                                </v-layout>
                                <v-layout wrap>
                                    <v-flex xs12 sm12 md12>
                                        <v-textarea
                                            name="input-7-4"
                                            label="Description*"
                                            required
                                            value=""
                                        ></v-textarea>
                                    </v-flex>
                                </v-layout>
                            </v-form>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click="dialog = false">Close</v-btn>
                        <v-btn
                            color="blue darken-1"
                            flat
                            :disabled="!valid"
                            @click="validate"

                        >Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
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
            Toolbar,
            board
        },
        props: ['board'],
        data() {
            return {
                columns: [],
                items: ['123', '456'],
                loaded: false,
                dialog: false,
                valid: true,
                title: '',
                column: null,
                description: ''
            }
        },
        methods: {
            getBoard() {
                axios.get('/api/boards/'+this.board).then(response => {
                    this.board = response.data;
                    this.loaded = true;
                }).catch( error => {
                    this.loaded = true;
                });
            },
            getColumns() {
                axios.get('/api/boards/'+this.board+'/columns').then(response => {this.columns = response.data}).catch(error => console.error(error));
            },
            showSnack() {
                this.snack = true;
            },
            validate () {
                if (this.$refs.form.validate()) {
                    alert('validou');
                    this.dialog = false;
                }
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
