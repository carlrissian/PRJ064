<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
        <label v-text="label"></label>
        <div class="kt-radio-inline">
            <label class="kt-radio" v-for="(item, index) in data" :key="index">
                <input @change="changeRadio" type="radio" :name="name" :value="item.value" :checked="item.checked"> {{ item.text }}
                <span></span>
            </label>
        </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "ErpRadioButtonModal",
        props: {
            classNumber: String,
            label: String,
            data: Array,
            name: String
        },
        methods: {
            changeRadio(e){
                this.$emit('updateRadioButton', e.target.value);
            }
        }
    }
</script>

<style scoped>

</style>