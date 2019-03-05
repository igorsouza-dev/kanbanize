<template>
    <v-dialog v-model="this.dialog.show" max-width="600">
        <v-card>
            <v-card-title>
                <span class="headline">New Card</span>
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
                                <label for="column">Coluna*</label>
                                <select class="form-control" v-model="column" id="column">
                                    <option v-for="item in parentBoard.columns" :rules="[v => !!v || 'A coluna é obrigatória']" :key="item.id" :value="item.id">{{ item.name }}</option>
                                </select>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <v-text-field label="Posição*" :rules="[v => !!v || 'A posição é obrigatória']" required v-model="column_position"></v-text-field>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <v-text-field label="Prazo*" type="date" :rules="[v => !!v || 'O prazo é obrigatório']" required v-model="deadline"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout>
                            <v-flex xs8 sm8 md8>
                                <v-text-field label="Título*" :rules="[v => !!v || 'O título é obrigatório']" required v-model="title"></v-text-field>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <v-text-field label="Cód. Chamado*" type="number" :rules="[v => !!v || 'O código do chamado é obrigatório']" required v-model="order_id"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout wrap>
                            <v-flex xs12 sm12 md12>
                                <v-textarea
                                    name="description"
                                    label="Descrição*"
                                    v-model="description"
                                    required
                                    :rules="[v => !!v || 'A descrição é obrigatória']"
                                    value=""
                                ></v-textarea>
                            </v-flex>
                        </v-layout>
                        <v-layout wrap>
                            <v-flex xs4 sm4 md4>
                                <label for="size">Size</label>
                                <select class="form-control" v-model="size" id="size">
                                    <option v-for="item in sizes" :key="item" :value="item">{{ item }}</option>
                                </select>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <label for="priority">Priority</label>
                                <select class="form-control" v-model="priority" id="priority">
                                    <option v-for="item in priorities" :key="item.key" :value="item.key">{{ item.value }}</option>
                                </select>
                            </v-flex>
                            <v-flex xs4 sm4 md4>
                                <label for="type">Type</label>
                                <select class="form-control" v-model="type" id="type">
                                    <option v-for="item in types" :key="item.key" :value="item.key">{{ item.value }}</option>
                                </select>
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-container>
            </v-card-text>
            <v-card-actions>
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
        name: "NewCardDialog",
        props: ['dialog', 'parentBoard'],
        components: {
            AppSectionLoader
        },
        data() {
            return {
                valid: false,
                showLoader: false,
                column: '',
                title: '',
                description: '',
                column_position: '',
                size: 1,
                sizes: [
                    '1','2','3','5','8','13','21','34'
                ],
                deadline: '',
                order_id: 0,
                priority: 1,
                priorities: [
                    {key: 1, value: 'Baixa'},
                    {key: 2, value: 'Média'},
                    {key: 3, value: 'Alta'},
                    {key: 4, value: 'Crítica'},
                ],
                type: 1,
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
                    this.addCard();
                }
            },
            addCard() {
                console.info(this.column);
                let data = {
                    column_id: this.column,
                    description: this.description,
                    title: this.title,
                    size: this.size,
                    column_position: this.column_position,
                    priority: this.priority,
                    deadline: this.deadline,
                    user_id: 1,
                    type: this.type,
                    color: 'primary',
                    order_id: this.order_id
                };
                axios.post('/cards', data).then(response => {
                    console.log(response.data);
                    this.updateParent();
                    this.close();
                }).catch(error => {
                    this.close();
                    console.error(error);
                });
            },
            updateParent() {
                this.$emit('updateParent')
            },
            close() {
                this.$emit('close');
            }
        }
    }
</script>

<style scoped>

</style>
