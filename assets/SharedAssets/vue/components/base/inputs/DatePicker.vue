<template>
    <div :class="divClass">
        <label v-if="label" :class="labelClass" :for="id" v-text="label"></label>
        <div class="input-group date">
            <input
                @input="onInputChange"
                @blur="formatAndSetDate"
                @keydown.enter="formatAndSetDate"
                type="text"
                :name="name"
                :ref="reference"
                :id="id"
                class="form-control date"
                :placeholder="placeholder"
                :autocomplete="autocomplete ? 'on' : 'off'"
                :readonly="readonly"
                :disabled="disabled"
                :required="required"
                v-model="date"
            />
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="la la-calendar" @click="show"></i>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {
    name: "DatePicker",
    props: {
        name: String,
        id: String,
        reference: {
            type: String,
            default: "input",
        },
        value: String,
        format: {
            type: String,
            default: "dd/mm/yyyy",
        },
        label: String,
        placeholder: {
            type: String,
            default: "dd/mm/yyyy",
        },
        autocomplete: {
            type: Boolean,
            default: false,
        },
        readonly: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        required: {
            type: Boolean,
            default: false,
        },
        divClass: {
            type: String,
            default: null,
        },
        labelClass: {
            type: String,
            default: "control-label",
        },
        limitStartDay: [Date, String],
        limitEndDay: [Date, String],
    },
    data() {
        return {
            element: null,
            date: this.value,
            tempDate: null,
        };
    },
    mounted() {
        this.element = $(`#${this.id}`);
        this.element.datepicker(this.getPropertiesDataPicker());
        this.element.on("changeDate", (e) => {
            this.date = e.target.value;
            this.$emit("updateDatePicker", e);
            this.$emit("updatedDatePicker", this.date);
        });
    },
    updated() {
        this.$nextTick(function() {
            this.element.datepicker("update");
        });
    },
    methods: {
        onInputChange(e) {
            this.tempDate = e.target.value; // tempDate = input value
        },
        getPropertiesDataPicker() {
            let obj = {
                format: this.format, // desde props se pasa un valor por defecto
                language: "es",
                orientation: this.orientation,
                todayHighlight: true,
                autoclose: true,
                clearBtn: true,
            };

            if (this.limitStartDay) {
                obj["startDate"] = this.limitStartDay;
            }
            if (this.limitEndDay) {
                obj["endDate"] = this.limitEndDay;
            }
            if (this.format && this.format.toLowerCase() === "yyyy") {
                Object.assign(obj, { viewMode: "years", minViewMode: "years" });
            }
            return obj;
        },
        formatAndSetDate(e) {
            let dateSequence = this.tempDate; // tempDate = input value

            const regex = /^(\d{1,2})(\d{1,2})(\d{2,4})$/;
            if (regex.test(dateSequence)) {
                dateSequence = dateSequence.replace(regex, "$1/$2/$3");
            }

            // Validación de la fecha pasando por distintos formatos
            let formats = ["D/M/YYYY", "D-M-YYYY", "DMYYYY"];
            let momentDate = null;

            // TODO: Según he consultado la documentación de Moment.js, si a moment se le pasara element array debería de funcionar. El problema es que no lo hace
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
                this.element.datepicker("update", date);
                // console.log(date, this.element.datepicker("getDate"));
                this.$emit("updatedDatePicker", date);
            }
            this.tempDate = null;
        },
        show() {
            this.element.datepicker("show");
        },
    },
    /*
        FIXME cambiar sentencias destroy por setters:
        https://bootstrap-datepicker.readthedocs.io/en/latest/methods.html#setstartdate
        https://bootstrap-datepicker.readthedocs.io/en/latest/methods.html#setenddate
     */
    watch: {
        limitEndDay() {
            this.element.datepicker("destroy").datepicker(this.getPropertiesDataPicker());
        },
        limitStartDay() {
            this.element.datepicker("destroy").datepicker(this.getPropertiesDataPicker());
        },
        value() {
            this.date = this.value;
        },
        date() {
            if (this.date === "" || this.date === null) {
                this.$emit("updatedDatePicker", this.date);
            }
        },
    },
};
</script>

<style scoped>
input:disabled {
    opacity: 0.65;
    cursor: not-allowed;
}
</style>
