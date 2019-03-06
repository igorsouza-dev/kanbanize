<template>
    <v-card :color="getColor" dark>
        <v-card-text>
            <div>
                {{cardData.title}}-{{ cardData.order_id }}
                <v-btn flat icon color="white" @click="deleteCard">
                    <v-icon small>delete</v-icon>
                </v-btn>
                <v-btn flat icon color="white">
                    <v-icon small>edit</v-icon>
                </v-btn>
            </div>
            <v-divider></v-divider>

            <div>{{ cardData.description }}</div>
            <div>{{ cardData.deadline }}</div>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions class="pa-3">
            <v-btn flat icon color="white" @click="moveCardLeft">
                <v-icon small>keyboard_arrow_left</v-icon>
            </v-btn>
            <v-btn flat icon color="white" @click="moveCardLeft">
                <v-icon small>keyboard_arrow_up</v-icon>
            </v-btn>

            <v-btn flat icon color="white" @click="moveCardRight">
                <v-icon small>keyboard_arrow_down</v-icon>
            </v-btn>
            <v-btn flat icon color="white" @click="moveCardRight">
                <v-icon small>keyboard_arrow_right</v-icon>
            </v-btn>
        </v-card-actions>
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
                color: 'primary'
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
            moveCardLeft() {
                axios.get('/cards/'+this.id+'/move-left').
                then(response => {
                    if(response.data.status === true) {
                        this.$emit('moved');
                    }
                }).catch(error => {

                });
            },
            moveCardRight() {
                axios.get('/cards/'+this.id+'/move-right').
                then(response => {
                    if(response.data.status === true) {
                        this.$emit('moved');
                    }
                }).catch(error => {

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

</style>
