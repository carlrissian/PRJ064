<template>
    <div :class="classNumber ? `col-md-${classNumber}` : 'col-md-1'">
        <div class="kt-checkbox-inline">
            <label class="kt-checkbox control-label" :for="id">
                <input  :checked="checked" class="form-control" type="checkbox" :name="name" :required="required" :id="id" > {{ label }}
                <span></span>
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpCheckboxFilter",
        props: {
            classNumber: String,
            id: String,
            name: String,
            label: String,
            checked: {
                type: Boolean,
                default: false
            },
            required: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style scoped>

</style>