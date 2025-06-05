<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <div class="input-group date">
                <datepicker class="col-9" v-model="item" :monday-first="true" :language="es" :format="'dd/MM/yyyy'" input-class="form-control" :name="name" :id="id"></datepicker>
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="fa fa-calendar"/>
                    </span>
                </div>
            </div>
         </div>
    </div>
</template>

<script>
    import datepicker from "vuejs-datepicker";
    import { es } from "vuejs-datepicker/dist/locale";
    export default {
        name: "ErpDatePickerModal",
        components:{ datepicker },
        props: {
            classNumber: String,
            label: String,
            id: String,
            name: String,
            value: String,
            format: String,
            placeholder: String,
            limitStartDay: Date,
            limitEndDay: Date
        },
        data() {
            return {
                item: '',
                es: es,
                type: 'calendar'
            }
        },
        mounted() {
            this.item = this.value;
            let el = $(`#${this.id}`);
            let $this = this;
            el.on('changeDate', function(e)  {
                $this.$emit('updateDatePicker', this.item);
            });

        },
        watch: {
            value() {
                this.item = this.value;
            }
        },
        methods:{
            setValue(date){
                let convertedDate = this.convertDate(date);
                this.item = new Date(moment(convertedDate).format('YYYY-MM-DD'));
            },
            getValue(){
                return this.item ? moment(this.item).format('DD/MM/YYYY') : '';
            },
            convertDate(date){
                let dateArray = date.split("/");
                return dateArray[2] + '/' + dateArray[1] + '/' + dateArray[0];

            }
        }
    }
</script>

<style scoped>
</style>