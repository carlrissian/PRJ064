<template>
    <div :class="classNumber ? `col-lg-${classNumber}` : 'col-lg-3'">
        <label :for="id" v-text="label"></label>
        <div class="kt-input-icon mb-3">
            <input :title="title" :type="type" class="form-control" :placeholder="placeholder" :name="name" :id="id">
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpInputFilter",
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            type: String,
            placeholder: String,
            title: String
        }
    }
</script>

<style scoped>

</style>