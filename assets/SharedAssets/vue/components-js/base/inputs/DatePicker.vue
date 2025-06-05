<template>
  <div :class="divClass">
    <label :class="labelClass" :for="id" v-text="label"></label>
    <div class="input-group date">
      <input :id="id"
             :name="name"
             :placeholder="placeholder"
             :readonly="readonly"
             :disabled="disabled"
             :required="required"
             v-model="date"
             class="form-control date"
             type="date"
             @input="onInputChange"
             @blur="formatAndSetDate"
             @keydown.enter="formatAndSetDate"
      >
      <div class="input-group-append">
                <span class="input-group-text">
                    <i class="la la-calendar" @click="show"></i>
                </span>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';

export default {
    name: "DatePicker",
    props: {
        id: String,
        label: String,
        name: String,
        value: String,
        format: {
            type: String,
            default: 'dd/mm/yyyy'
        },
        placeholder: {
            type: String,
            default: "dd/mm/yyyy"
        },
        readonly: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
        },
        divClass: {
            type: String,
            default: null,
        },
        labelClass: {
            type: String,
            default: 'control-label'
        },
        limitStartDay: [Date, String],
        limitEndDay: [Date, String],
    },
    data() {
        return {
          date: this.value,
          tempDate: null,
        }
    },
    mounted() {

    },
    methods: {
        onInputChange(e) {
          this.tempDate = e.target.value; // tempDate = input value
        },
        getPropertiesDataPicker() {
            let obj = {
                format: this.format, // desde props se pasa un valor por defecto
                language: 'es',
                orientation: this.orientation,
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
                Object.assign(obj, {viewMode: "years", minViewMode: "years"})
            }
            return obj;
        },
        formatAndSetDate(e) {

            let dateSequence = this.tempDate; // tempDate = input value

                const regex = /^(\d{1,2})(\d{1,2})(\d{2,4})$/;
                if (regex.test(dateSequence)) {
                    dateSequence = dateSequence.replace(regex, '$1/$2/$3');
                }

                // Validación de la fecha pasando por distintos formatos
                let formats = ['D/M/YYYY', 'D-M-YYYY', "DMYYYY"]
                let momentDate = null;

                // TODO: Según he consultado la documentación de Moment.js, si a moment se le pasara el array debería de funcionar. El problema es que no lo hace
                for (let formattmp of formats) {
                    momentDate = moment(dateSequence, formattmp);
                    if (momentDate.isValid()) {
                        break;
                    }
                }
                // Si la fecha es válida
                if (momentDate && momentDate.isValid()) {
                    // Creación del string de fecha
                    let formatMoment = this.format.toUpperCase(); // Moment usa mayúsculas en su formato
                    let date = momentDate.format(formatMoment);
                    // Actualizado del datepicker
                    this.date = date;
                    // Actualizado del valor del input
                    this.$emit('updatedDatePicker', date);
                }
                this.tempDate = null;
        },
        show() {
          document.getElementById(this.id).focus();
        }
    },
    watch: {
      value() {
        this.date = this.value
      }
    }
}

</script>
<style scoped>

</style>
