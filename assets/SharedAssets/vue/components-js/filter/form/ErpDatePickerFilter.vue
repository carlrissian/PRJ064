<template>
    <div  :class="classNumber ? `col-lg-${classNumber}` : 'col-lg-2'">
         <div class="row mb-3 justify">
             <div class="col-12">
                 <date-picker
                     :id="id"
                     :name="name"
                     :readonly="readonly"
                     :placeholder="placeholder"
                     :value="value"
                     :format="format"
                     :limit-start-day="limitStartDay"
                     :limit-end-day="limitEndDay"
                     :label="label"
                     :label-class="'col-11 col-form-label'"
                     @updateDatePicker="datePickerUpdated"
                 />
             </div>
         </div>
    </div>
</template>

<script>
    import DatePicker from "../../base/inputs/DatePicker.vue";
    export default {
        name: "ErpDatePickerFilter",
        components: {DatePicker},
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            value: String,
            format: String,
            placeholder: "dd/mm/yyyy",
            readonly: false,
            orientation: {
                type: String,
                default: "bottom left"
            },
          limitStartDay: [Date, String],
          limitEndDay: [Date, String],
        },
        methods: {
            datePickerUpdated(e) {
                this.$emit('updateDatePicker', e);
            },
        }
    }
</script>

<style scoped>
.justify {
    justify-content: space-evenly;
}
</style>