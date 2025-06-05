<template>
    <div  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <select  class="form-control kt-select2" :name="name" :id="id">
            <slot></slot>
        </select>
    </div>
</template>

<script>
    export default {
        name: "ErpSelect2",
        props: {
            classNumber: String,
            id: String,
            name: String,
            label: String
        },

        mounted() {
            let $this = this;
            this.el = $(`#${this.id}`);
            this.el.select2({
                selectionTitleAttribute: false
            });

            this.el.val('').trigger('change');

            this.el.select2().on('change', function() {
                $this.$emit('changeValue', $(this).val());
            }).trigger('change');
        },
    }
</script>

<style>
    .select2-container {
        width: 100% !important;
    }
</style>