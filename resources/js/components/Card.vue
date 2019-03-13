<template>
    <!--<v-sheet
            class="d-flex"
            :color="getColor"
            height="100"
    >
        <v-layout column wrap>
            <v-flex>
                <v-layout row>
                    <v-flex>
                        <span >{{cardData.title}}-{{ cardData.order_id }}</span>
                        <v-btn flat icon color="white" @click="deleteCard">
                            <v-icon small>delete</v-icon>
                        </v-btn>
                        <v-btn flat icon color="white">
                            <v-icon small>edit</v-icon>
                        </v-btn>
                        <div>{{ cardData.description }}</div>

                    </v-flex>
                </v-layout>
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
            </v-flex>

        </v-layout>

    </v-sheet>-->
    <v-card :color="getColor" dark class="clickable" >
        <v-card-text style="padding: 8px; margin: 0">
            <v-layout row>
                <v-flex sm2 md2 xl2>
                    {{cardData.title}}-{{ cardData.order_id }}
                </v-flex>
                <v-flex sm2 md2 xl2>
                    <v-btn flat icon color="white" @click="deleteCard">
                        <v-icon small>delete</v-icon>
                    </v-btn>
                </v-flex>
                <v-flex sm2 md2 xl2>
                    <v-btn flat icon color="white">
                        <v-icon small>edit</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>



            <v-divider></v-divider>
            <div>{{ cardData.description }}</div>
        </v-card-text>
        <!--<v-card-actions class="pa-3" style="padding: 0; margin: 0">-->
            <!--<v-btn flat icon color="white" @click="moveCardLeft">-->
                <!--<v-icon small>keyboard_arrow_left</v-icon>-->
            <!--</v-btn>-->
            <!--<v-btn flat icon color="white" @click="moveCardLeft">-->
                <!--<v-icon small>keyboard_arrow_up</v-icon>-->
            <!--</v-btn>-->

            <!--<v-btn flat icon color="white" @click="moveCardRight">-->
                <!--<v-icon small>keyboard_arrow_down</v-icon>-->
            <!--</v-btn>-->
            <!--<v-btn flat icon color="white" @click="moveCardRight">-->
                <!--<v-icon small>keyboard_arrow_right</v-icon>-->
            <!--</v-btn>-->
        <!--</v-card-actions>-->
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
                items: [
                    { title: 'Click Me' },
                    { title: 'Click Me' },
                    { title: 'Click Me' },
                    { title: 'Click Me 2' }
                ]
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
</style>
