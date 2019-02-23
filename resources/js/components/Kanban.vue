<template>
    <div>
        <board :columns="columns"></board>
    </div>
</template>

<script>
    import board from './Board';
    import axios from 'axios';
    export default {
        name: "Kanban",
        components:{
            board
        },
        props: ['board'],
        data() {
            return {
                columns: []
            }
        },
        methods: {
            getColumns() {
                axios.get('/api/boards/'+this.board+'/columns').then(response => {this.columns = response.data}).catch(error => console.error(error));
            }
        },
        mounted() {
            this.getColumns();
        }
    }
</script>

<style scoped>

</style>
