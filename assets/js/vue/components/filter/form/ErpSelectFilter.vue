<template>
    <div class="col-lg-3">
         <div class="row mb-3">
            <label class="col-4 col-form-label" :for="id" v-text="label"></label>
            <div class="col-8">
                <select :name="name" class="form-control" :id="id">
                    <option value=""></option>
                    <slot></slot>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpSelectFilter",
        props: {
            label: String,
            id: String,
            name: String
        }
    }
</script>

<style scoped>

</style>