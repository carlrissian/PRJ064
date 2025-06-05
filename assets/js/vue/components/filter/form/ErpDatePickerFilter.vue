<template>
    <div :class="classNumber ? `col-lg-${classNumber}` : 'col-lg-3'">
        <label :for="id" v-text="label"></label>
        <div class="input-group date">
            <input type="text" :value="value" class="form-control date" :name="name" :id="id" readonly="" :placeholder="placeholder">
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="la la-calendar"></i>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpDatePickerFilter",
        props: {
            label: String,
            classNumber: String,
            id: String,
            name: String,
            value: String,
            format: String,
            placeholder: String,
            orientation: {
                type: String,
                default: "bottom left"
            },
            limitStartDay: Date,
            limitEndDay: Date
        },
        mounted() {
            let el = $(`#${this.id}`);
            el.datepicker(this.getPropertiesDataPicker());
            let $this = this;
            el.on('changeDate', function(e)  {
                $this.$emit('updateDatePicker', this.value);
            });
        },
        methods: {
            getPropertiesDataPicker() {
                let obj = {
                    format: this.format || 'dd/mm/yyyy',
                    language: 'es',
                    orientation:this.orientation,
                    todayHighlight: true,
                    autoclose: true
                };
                if (this.limitStartDay) {
                    obj['startDate'] = this.limitStartDay;
                }

                if (this.limitEndDay) {
                    obj['endDate'] = this.limitEndDay;
                }
                if (this.format && this.format.toLowerCase() === 'yyyy') {
                    Object.assign(obj, { viewMode: "years", minViewMode: "years" })
                }
                return obj;
            }
        }
    }
</script>

<style scoped>
</style>