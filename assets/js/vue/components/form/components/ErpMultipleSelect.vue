<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <select @change="changeValue" :type="type" class="form-control kt-selectpicker" :name="name" :id="id" multiple data-size="5" data-live-search="true">
                <slot></slot>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpMultipleSelect",
        props: {
            classNumber: String,
            id: String,
            type: String,
            name: String,
            label: String,
            value: Array,
            dataForAjax: Array,
            defaultText: String
        },
        data() {
            return {
                el: null,
                valueDataAjax: Array
            }
        },
        methods:{
            changeValue(e){
                this.$emit('changeValue', e);
            }
        },
        mounted() {
            this.el = $(`#${this.id}`);
            this.el.selectpicker({
                noneSelectedText : this.defaultText ?? '',
                actionsBox: true
            });
        },
        watch: {
            valueDataAjax() {
                this.el.val(this.value);
                this.el.selectpicker("refresh");
            },
            value() {
                this.el.val(this.value);
                this.el.selectpicker("refresh");
            },
            dataForAjax() {
                this.dataForAjax.forEach(item => {
                    this.el.append($("<option>", {
                        value: item.id,
                        text: item.name
                    }));
                    this.valueDataAjax = this.value;
                    this.el.selectpicker("refresh");
                });
            }
        }
    }
</script>
<style scoped>

</style>