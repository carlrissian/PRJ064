<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <select :type="type" class="form-control kt-selectpicker" :name="name" :id="id" multiple data-size="5" data-live-search="true">
                <slot></slot>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpMultipleSelectModal",
        props: {
            classNumber: String,
            id: String,
            type: String,
            name: String,
            label: String,
            value: Array
        },
        data() {
            return {
                el: null
            }
        },
        mounted() {
            this.el = $(`#${this.id}`);
            this.el.selectpicker({
                noneSelectedText : this.label,
                actionsBox: true
            });
        },
        watch: {
            value() {
                this.el.val(this.value);
                this.el.selectpicker("refresh");
            }
        }
    }
</script>
<style scoped>

</style>