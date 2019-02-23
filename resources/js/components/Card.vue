<template>
    <v-card color="purple" dark>
        <v-card-title primary class="title">{{title}}</v-card-title>
        <v-card-text>{{ lorem }}</v-card-text>
    </v-card>
</template>

<script>
    export default {
        name: "Card",
        props:['title'],
        data: () => ({
            lorem: `Lorem ipsum dolor sit amet, mel at clita quando. Te sit oratio vituperatoribus, nam ad ipsum posidonium mediocritatem, explicari dissentiunt cu mea. Repudiare disputationi vim in, mollis iriure nec cu, alienum argumentum ius ad. Pri eu justo aeque torquatos.`
        })
    }
</script>

<style scoped>

</style>
