<template>
    <div :class="(classNumber ? `col-md-${classNumber}` : 'col-md-3') + divClass">
        <div class="form-group">
                <date-picker-element :id="id" :name="name" :readonly="readonly"
                                     :placeholder="placeholder" :value="value" :format="format"
                                     :limit-start-day="limitStartDay" :limit-end-day="limitEndDay"
                                     @updatedDatePicker="datePickerUpdated" :label="label"
                                     :disabled="disabled" :required="required"
                />
        </div>
    </div>
</template>

<script>
    import DatePickerElement from "../../base/inputs/DatePicker.vue";
    export default {
        name: "ErpDatePickerStaticFilter",
        components: {DatePickerElement},
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            value: String,
            format: String,
            placeholder: String,
            divClass: {
                type: String,
                default: ''
            },
            limitStartDay: [Date, String],
            limitEndDay: [Date, String],
            disabled: Boolean,
            readonly: false,
            required: false
        },
        emits: ['updatedDatePicker'],
        // event: 'update',
        methods: {
            datePickerUpdated(date) {
                this.$emit('updatedDatePicker', date);
            }
        },
    }
</script>

<style scoped>
</style>