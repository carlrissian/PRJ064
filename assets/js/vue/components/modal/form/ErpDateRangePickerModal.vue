<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <input  type="text" class="form-control date-range" :name="name" :id="id" readonly="" :value="value" >
         </div>
    </div>
</template>

<script>
    export default {
        name: "ErpDateRangePickerModal",
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            startDate: null,
            endDate: null,
            format: String,
            value: String
        },
        mounted() {
            let el = $(`#${this.id}`);
            el.daterangepicker({
                autoUpdateInput: false,
                startDate: this.startDate,
                endDate: this.endDate,
                locale: {
                    format: this.format
                }
            });

            el.on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            el.on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            let $this = this;
            el.on('changeDate', function(e) {
                $this.$emit('updateRangeDatePicker', this.value);
            });
        }
    }
</script>

<style scoped>

</style>