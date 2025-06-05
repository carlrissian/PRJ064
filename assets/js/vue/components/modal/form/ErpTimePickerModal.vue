<template>
    <div  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <div class="input-group date">
            <input type="text" :value="value" class="form-control" :id="id" :name="name" >
            <div class="input-group-append">
                 <span class="input-group-text">
                    <i class="la la-calendar-check-o glyphicon-th"></i>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpTimePickerModal",
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            value: String,
            placeholder: String
        },
        mounted() {
            let el = $(`#${this.id}`);
            el.datetimepicker({
                todayHighlight: true,
                autoclose: true,
                pickerPosition: 'bottom-left',
                format: 'dd/mm/yyyy hh:ii'
            });
            let $this = this;
            el.on('changeDate', function(e)  {
                $this.$emit('updateDatePicker', this.value);
            });
        }
    }
</script>

<style scoped>

</style>