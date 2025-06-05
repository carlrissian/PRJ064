<template>
        <bootstrap-table :columns="columns" :data="data" :options="options"/>
</template>

<script>
    export default {
        name: "ErpStaticTable",
        props: {
            columns: Array,
            data: [Array,Object],
            options: Object
        }
    }
</script>

<style scoped>

</style>