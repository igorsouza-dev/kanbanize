<template>
    <v-dialog v-model="this.dialog.show" max-width="600">
        <v-card>
            <v-card-title>
                <span class="headline">{{ this.parentBoard.card.id ? 'Editar' : 'Novo' }} Card</span>
            </v-card-title>
            <v-card-text>
                <app-section-loader :status="showLoader"></app-section-loader>
                <v-container grid-list-md>
                    <v-form
                        ref="form"
                        v-model="valid"
                        lazy-validation
                    >
                        <v-layout wrap>
                            <v-flex xs4 sm4 md4>
                                <label for="column_id">Coluna*</label>
                                <select class="form-control" v-model="parentBoard.card.column_id" id="column_id">
                                    <option v-for="item in parentBoard.columns" :rules="[v => !!v || 'A coluna é obrigatória']" :key="item.id" :value="item.id">{{ item.name }}</option>
                                </select>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <label for="column_id">Usuário</label>
                                <select class="form-control" v-model="parentBoard.card.user_id" id="user_id">
                                    <option v-for="item in parentBoard.users" :key="item.codusuario" :value="item.codusuario">{{ item.nome }}</option>
                                </select>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <v-text-field label="Prazo*" type="date" :rules="[v => !!v || 'O prazo é obrigatório']" required v-model="parentBoard.card.deadline"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex xs8 sm8 md8>
                                <v-text-field label="Título*" :rules="[v => !!v || 'O título é obrigatório']" required v-model="parentBoard.card.title"></v-text-field>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <v-text-field label="Cód. Chamado*" type="number" :rules="[v => !!v || 'O código do chamado é obrigatório']" required v-model="parentBoard.card.order_id"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout wrap>
                            <v-flex xs12 sm12 md12>
                                <v-textarea
                                    name="description"
                                    label="Descrição*"
                                    v-model="parentBoard.card.description"
                                    required
                                    :rules="[v => !!v || 'A descrição é obrigatória']"
                                    value=""
                                ></v-textarea>
                            </v-flex>
                        </v-layout>
                        <v-layout wrap>
                            <v-flex xs4 sm4 md4>
                                <label for="size">Tamanho</label>
                                <select class="form-control" v-model="parentBoard.card.size" id="size">
                                    <option v-for="item in sizes" :key="item" :value="item">{{ item }}</option>
                                </select>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <label for="priority">Prioridade</label>
                                <select class="form-control" v-model="parentBoard.card.priority" id="priority">
                                    <option v-for="item in priorities" :key="item.key" :value="item.key">{{ item.value }}</option>
                                </select>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <label for="type">Tipo</label>
                                <select class="form-control" v-model="parentBoard.card.type" id="type">
                                    <option v-for="item in types" :key="item.key" :value="item.key">{{ item.value }}</option>
                                </select>
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn v-if="parentBoard.card.id" class="btn-excluir" @click="deleteCard" color="red">Excluir</v-btn>
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
    import AppSectionLoader from "./AppSectionLoader";
    import axios from 'axios';
    export default {
        name: "CardDialog",
        props: ['dialog', 'parentBoard'],
        components: {
            AppSectionLoader
        },
        data() {
            return {
                valid: false,
                showLoader: false,

                sizes: [
                    '1','2','3','5','8','13','21','34'
                ],

                priorities: [
                    {key: 1, value: 'Baixa'},
                    {key: 2, value: 'Média'},
                    {key: 3, value: 'Alta'},
                    {key: 4, value: 'Crítica'},
                ],

                types: [
                    {key: 1, value: 'Corretiva'},
                    {key: 2, value: 'Adaptativa'},
                    {key: 3, value: 'Perfectiva'},
                ]
            }
        },
        methods: {
            validate () {
                if (this.$refs.form.validate()) {
                    if(this.parentBoard.card.id > 0) {
                        this.saveCard();
                    } else {
                        this.addCard();
                    }
                }
            },
            addCard() {

                axios.post('/api/cards/add', this.getData()).then(response => {
                    this.updateParent();
                    this.close();
                }).catch(error => {
                    this.close();
                    console.error(error);
                });
            },
            saveCard() {
                axios.put('/api/cards/edit/id/'+this.parentBoard.card.id, this.getData()).then(response => {
                    this.updateParent();
                    this.close();
                }).catch(error => {
                    this.close();
                    console.error(error);
                });
            },
            deleteCard() {
                axios.delete('/cards/'+this.parentBoard.card.id).
                then(response => {
                    this.close();
                    this.$emit('deletedCard');
                }).catch(error => {
                    this.close();
                });
            },
            updateParent() {
                this.$emit('updateParent')
            },
            getData() {
                return {
                    column_id: this.parentBoard.card.column_id,
                    description: this.parentBoard.card.description,
                    title: this.parentBoard.card.title,
                    size: this.parentBoard.card.size,
                    priority: this.parentBoard.card.priority,
                    deadline: this.parentBoard.card.deadline,
                    user_id: this.parentBoard.card.user_id,
                    type: this.parentBoard.card.type,
                    color: 'primary',
                    order_id: this.parentBoard.card.order_id
                };
            },
            close() {
                this.$emit('close');
            }
        }
    }
</script>

<style scoped>
    .btn-excluir{
        color: white;
    }
</style>
