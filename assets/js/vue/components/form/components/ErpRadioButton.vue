<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label v-text="label"></label>
<!--            <div :class="kt-radio-list">-->
            <div :class=" classRadio ? `kt-radio-${classRadio}` : 'kt-radio-inlinea'">
                <label class="kt-radio" v-for="(item, index) in data" :key="index">
                    <input @change="changeRadio" type="radio" :name="name" :value="item.id" :checked="item.checked"> {{ item.name }}
                    <span></span>
                </label>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "ErpRadioButton",
        props: {
            classNumber: String,
            classRadio: String,
            label: String,
            data: {},
            name: String
        },
        methods: {
            changeRadio(e){
                this.$emit('radiobuttonSelected', e.target.value);
            }
        }
    }
</script>

<style scoped>

</style>