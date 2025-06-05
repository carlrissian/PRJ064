<template>
    <div :class="classNumber ? `col-md-${classNumber}` : 'col-md-1'">
        <label></label>
        <div class="kt-checkbox-inline">
            <label class="kt-checkbox control-label" :for="id">
                <input class="form-control" type="checkbox" :name="name" :id="id" v-on:change="$emit('onChangeCheckbox', $event)" :checked="checked"> {{ label }}
                <span></span>
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpCheckbox",
        props: {
            classNumber: String,
            id: String,
            name: String,
            label: String,
            checked: Boolean
        }
    }
</script>

<style scoped>

</style>