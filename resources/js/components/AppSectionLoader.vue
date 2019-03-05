<template>
    <div class="loader-overlay" v-if="status">
        <v-progress-circular indeterminate color="primary"></v-progress-circular>
    </div>
</template>

<script>
    export default {
        name: "AppSectionLoader",
        props: ["status"]
    }
</script>

<style scoped>

</style>
