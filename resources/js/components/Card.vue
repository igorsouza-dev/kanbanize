<template>
    <v-card :color="getColor" dark class="clickable" >
        <v-card-text style="padding: 8px; margin: 0">
                <v-layout  row >
                    <v-flex xs8>
                        {{cardData.title}}-{{ cardData.order_id }}
                    </v-flex>
                    <v-flex xs2>
                        <v-btn flat icon color="white" @click="deleteCard" class="very-small">
                            <v-icon small >delete</v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs2>
                        <v-btn flat icon color="white" @click="editCard" class="very-small">
                            <v-icon small  >edit</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
            <div>{{ cardData.description }}</div>
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
                color: 'primary',

            }
        },
        methods: {
            deleteCard() {
                axios.delete('/cards/'+this.id).
                then(response => {
                    this.$emit('deleted');
                }).catch(error => {

                });
            },
            editCard() {
                this.$emit('editCard', this.cardData);
            },
            moveCardLeft() {
                axios.get('/cards/'+this.id+'/move-left').
                then(response => {
                    if(response.data.status === true) {
                        this.$emit('moved');
                    } else {
                        this.$emit('moved', response.data.error);
                    }
                }).catch(error => {
                    this.$emit('moved', error.error);
                });
            },
            moveCardRight() {
                axios.get('/cards/'+this.id+'/move-right').
                then(response => {
                    if(response.data.status === true) {
                        this.$emit('moved');
                    } else {
                        this.$emit('moved', response.data.error);
                    }
                }).catch(error => {
                    this.$emit('moved', error.error);
                });
            }
        },
        computed: {
            getColor: function() {
                let colors = [];
                colors[1] = 'red';
                colors[2] = 'yellow darken-2';
                colors[3] = 'green';
                this.color = colors[this.card.type];
                return this.color;
            }
        }
    }
</script>

<style scoped>
    .clickable{
        cursor:pointer
    }
    .very-small {
        height: 16px !important;
        width: 16px !important;
    }

</style>
