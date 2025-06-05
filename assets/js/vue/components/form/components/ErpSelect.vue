<template>
    <div  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <select @change="changeValue" class="form-control" :name="name" :id="id" :disabled="disabled" :required="required">
            <slot></slot>
        </select>
    </div>
</template>

<script>
    export default {
        name: "ErpSelect",
        props: {
            classNumber: String,
            id: String,
            name: String,
            label: String,
            disabled: Boolean,
            required: {
                type: Boolean,
                default: false
            }
        },
        methods:{
            changeValue(e){
                this.$emit('changeValue', e);
            }
        }
    }
</script>

<style scoped>

</style>