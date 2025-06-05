<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <input v-model="item"  :type="type" class="form-control" :readonly="readOnly" :name="name" :id="id" :placeholder="placeholder">
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpInputModal",
        props: {
            classNumber: String,
            id: String,
            type: String,
            name: String,
            label: String,
            value: String,
            placeholder: String,
            readOnly: String,
        },
        data() {
            return {
                item: ''
            }
        },
        mounted() {
            this.item = this.value;
        },
        watch: {
            item() {
                this.$emit('changeUpdateInput', this.item);
            },
            value() {
                this.item = this.value;
            }
        },
        methods:{
            getValue(){
                return this.item;
            }
        }
    }
</script>
<style scoped>

</style>