<template>
    <v-card :color="getColor" dark class="clickable" style="margin-top: 4px">
        <v-layout row >
            <v-sheet :color="usuario.cor" class="d-flex" width="100%" style="padding-left: 4px">
                {{ usuario.nome }}
            </v-sheet>
        </v-layout>
        <v-card-text style="padding: 8px;">

                <v-layout  row >
                    <v-flex xs11>
                        <a type="button" href="#" @click="editCard">{{cardData.title}}</a>
                    </v-flex>

                    <v-flex xs1>
                        <v-btn slot="activator" flat icon color="white" @click="openServiceOrder" :title="'Chamado nº' + this.cardData.order_id" class="very-small">
                            <v-icon small>link</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs4>
                        <v-chip text-color="white" @click="editCard" class="chips edit">{{ this.cardData.size }}</v-chip>
                    </v-flex>
                    <v-flex xs7 >
                        {{ this.tag }}
                    </v-flex>
                    <v-flex xs1>
                        <v-sheet class="very-small edit" @click="editCard" :color="getColorPriority" :title="getPriorityDescription" style="border: solid white 1px; padding: 0; margin: 0"></v-sheet>
                    </v-flex>
                </v-layout>
        </v-card-text>
    </v-card>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "Card",
        props:['cardData'],
        data() {
            return {
                id: this.cardData.id,
                card: this.cardData,
                order_id: this.cardData.order_id,
                size: this.cardData.size,
                color: 'primary',
                tag: '',
                usuario: {},
                priorityColor: '',
                priorityDescription: '',
            }
        },
        methods: {
            deleteCard() {
                axios.delete('/api/cards/delete/id/'+this.cardData.id).
                then(response => {
                    this.$emit('deleted');
                }).catch(error => {
                    console.error(error.message);
                });
            },
            editCard() {
                this.$emit('editCard', this.cardData);
            },
            openServiceOrder() {
                window.open('/manager/chamados/abrir/id/'+this.cardData.order_id);
            }
        },

        computed: {
            getColor: function() {
                let colors = [];
                colors[1] = '#cc1a33'; //corretiva
                colors[2] = '#FFCC11'; //adaptativa
                colors[3] = '#34A97B'; //perfectiva
                this.color = colors[this.cardData.type];
                return this.color;
            },
            getPriorityDescription: function() {
                let priorities = [];
                priorities[1] = 'Baixa';
                priorities[2] = 'Média';
                priorities[3] = 'Alta';
                priorities[4] = 'Crítica';
                this.priorityDescription = priorities[this.cardData.priority];
                return this.priorityDescription;

            },
            getColorPriority: function() {
                let colors = [];
                colors[1] = '#067db7';
                colors[2] = '#06a939';
                colors[3] = '#fb9900';
                colors[4] = '#cc0019';
                this.priorityColor = colors[this.cardData.priority];
                return this.priorityColor;
            }
        },
        mounted() {
            if(this.cardData.order_id) {
                this.tag = this.cardData.order_id;
            }
            if(this.cardData.tag) {
                if(this.tag != '') {
                    this.tag += ' - '+this.cardData.tag;
                }
            }
            if(this.cardData.usuario === undefined) {
                this.usuario = {
                    nome: '',
                    cor: 'grey'
                }
            } else {
                this.usuario = this.cardData.usuario;
            }
        }
    }
</script>

<style scoped>
    .clickable{
        cursor: grab;
    }
    .edit {
        cursor: pointer;
    }
    .edit:hover {
        border: solid red 1px;
    }
    a {
        color: black;
        text-decoration: underline white;
    }
    a:hover {
        text-decoration: underline black;
    }
    a:active {
        color: black;
        text-decoration: underline black;
    }
    a:visited {
        color: black
    }
    .chips {
        font-size: 10px;
        margin: 0;
        padding: 0;
        height: 16px;
    }
    .very-small {
        height: 16px !important;
        width: 16px !important;
        padding: 0;
        margin: 0;
    }

</style>
