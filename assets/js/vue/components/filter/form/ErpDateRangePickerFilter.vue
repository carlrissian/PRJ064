<template>
    <div class="col-lg-3">
         <div class="row mb-3">
            <label class="col-4 col-form-label" :for="id" v-text="label"></label>
             <div class="col-8">
                 <div class="input-group date">
                     <input type="text" class="form-control date-range" :name="name" :id="id" readonly="" >
                     <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                     </div>
                 </div>
             </div>
         </div>
    </div>
</template>

<script>
    import 'bootstrap-daterangepicker';
    export default {
        name: "ErpDateRangePickerFilter",
        props: {
            label: String,
            id: String,
            name: String,
            startDate: null,
            endDate: null,
            format: String
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
        }
    }
</script>

<style scoped>

</style>