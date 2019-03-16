<template>
    <v-card :color="getColor" dark class="clickable" >
        <v-card-text style="padding: 8px; margin: 0">
                <v-layout  row >
                    <v-flex xs10>
                        {{cardData.title}}-{{ cardData.order_id }}
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

            editCard() {
                this.$emit('editCard', this.cardData);
            },

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
        cursor: grab;
    }
    .very-small {
        height: 16px !important;
        width: 16px !important;
    }

</style>
