<template>
    <v-dialog v-model="this.dialog.show" max-width="600">
        <v-card>
            <v-card-title>
                <span class="headline">Coluna</span>
            </v-card-title>
            <v-card-text>
                <app-section-loader :status="showLoader"></app-section-loader>
                <v-container grid-list-md>
                    <v-form
                        ref="form"
                        v-model="valid"
                        lazy-validation
                    >
                        <v-layout>
                            <v-flex xs8 sm8 md8>
                                <v-text-field label="Nome*" :rules="[v => !!v || 'O nome é obrigatório']" required v-model="parentBoard.column.name"></v-text-field>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <v-text-field label="Nº Máx. Cards.*" type="number" :rules="[v => !!v || 'O nº máximo de cards é obrigatório']" required v-model="parentBoard.column.max_cards"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn v-if="parentBoard.column.id" class="btn-excluir" @click="deleteColumn" color="red">Excluir</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="close">Fechar</v-btn>
                <v-btn
                    color="blue darken-1"
                    flat
                    :disabled="!valid"
                    @click="validate"
                >
                    Salvar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import AppSectionLoader from './AppSectionLoader';
    import axios from 'axios';
    export default {
        name: "ColumnDialog",
        props: ['dialog', 'parentBoard'],
        components: {
            axios,
            AppSectionLoader
        },
        data() {
            return {
                valid: false,
                showLoader: false,
            }
        },
        methods: {
            validate () {
                if (this.$refs.form.validate()) {
                    if(this.parentBoard.column.id > 0) {
                        this.saveColumn();
                    } else {
                        this.addColumn();
                    }
                }
            },
            addColumn() {

                axios.post('/columns', this.getData()).then(response => {
                    this.updateParent();
                    this.close();
                }).catch(error => {
                    this.close();
                    console.error(error);
                });
            },
            saveColumn() {

                axios.put('/columns/'+this.parentBoard.column.id, this.getData()).then(response => {
                    this.updateParent();
                    this.close();
                }).catch(error => {
                    this.close();
                    console.error(error);
                });
            },
            deleteColumn() {
                axios.delete('/columns/'+this.parentBoard.column.id).
                then(response => {
                    this.close();
                    this.$emit('deletedColumn');
                }).catch(error => {
                    this.close();
                });
            },
            getData() {
                return {
                    board_id: this.parentBoard.column.board_id,
                    name: this.parentBoard.column.name,
                    max_cards: this.parentBoard.column.max_cards,
                };
            },
            close() {
                this.$emit('close');
            },
            updateParent() {
                this.$emit('updateParent')
            },
        }
    }
</script>

<style scoped>
    .btn-excluir{
        color: white;
    }
</style>
