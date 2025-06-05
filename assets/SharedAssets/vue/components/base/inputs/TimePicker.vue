<template>
    <div :class="divClass">
        <label v-if="label" :class="labelClass" :for="id" v-text="label"></label>
        <div class="input-group time">
            <input
                @input="onInputChange"
                @blur="formatAndSetTime"
                @keydown.enter="formatAndSetTime"
                type="text"
                :name="name"
                :ref="reference"
                :id="id"
                class="form-control timepicker"
                :placeholder="placeholder"
                :autocomplete="autocomplete ? 'on' : 'off'"
                :readonly="readonly"
                :disabled="disabled"
                :required="required"
                v-model="time"
                data-minute-step="1"
            />
            <div @click="show" class="input-group-append">
                <span class="input-group-text">
                    <i class="fa fa-hourglass-half"></i>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TimePicker",
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
            default: "HH:mm",
        },
        interval: {
            type: Number,
            default: null,
        },
        limitStartTime: {
            type: String,
            required: false,
            validator: function(value) {
                return ![null, undefined, ""].includes(value);
            },
        },
        limitEndTime: {
            type: String,
            required: false,
            validator: function(value) {
                return ![null, undefined, ""].includes(value);
            },
        },
        defaultTime: {
            type: String,
            required: false,
            validator: function(value) {
                return ![null, undefined, ""].includes(value);
            },
        },
        label: String,
        placeholder: {
            type: String,
            default: "hh:mm",
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
    },
    data() {
        return {
            element: null,
            time: this.value,
            tempTime: null,
            minTime: null,
            maxTime: null,
        };
    },
    mounted() {
        // Bootstrap Timepicker JS Doc official: https://jdewit.github.io/bootstrap-timepicker/
        this.element = $(`#${this.id}`);
        this.element.timepicker(this.getPropertiesTimePicker());
        this.element.on("changeTime.timepicker", (e) => {
            this.time = e.time.value;
            this.$emit("onChangeTimePicker", e);
            this.$emit("updatedTimePicker", this.time);
        });
    },
    methods: {
        onInputChange(e) {
            this.tempTime = e.target.value; // tempTime = input value
        },
        getPropertiesTimePicker() {
            let obj = {
                timeFormat: this.format, // desde props se pasa un valor por defecto
                defaultTime: this.defaultTime ? this.defaultTime : this.time,
                dynamic: false,
                dropdown: true,
                scrollbar: true,
                showMeridian: false,
                icons: {
                    up: "fa fa-angle-up",
                    down: "fa fa-angle-down",
                },
            };

            return obj;
        },
        formatAndSetTime() {
            if (this.tempTime) {
                let timeSequence = this.tempTime; // tempTime = input value

                timeSequence = this.validate(timeSequence);

                // Validación de la hora pasando por distintos formatos
                let formats = ["hh:mm", "hh:mm:ss", "hh:mm a", "hh:mm:ss a"];
                let momentTime = null;

                /**
                 * @author adrian.gaman
                 * TODO: Según he consultado la documentación de Moment.js, si a moment se le pasara el array debería de funcionar. El problema es que no lo hace
                 */
                for (let formattmp of formats) {
                    momentTime = moment(timeSequence, formattmp);
                    if (momentTime.isValid()) {
                        break;
                    }
                }

                // Si la hora es válida
                if (momentTime && momentTime.isValid()) {
                    // Creación del string de hora
                    let time = momentTime.format(this.format);
                    // Actualización del timepicker
                    this.time = time;
                    this.$emit("updatedTimePicker", this.time);
                }
                this.tempTime = null;
            }
        },
        validate(timeSequence) {
            const regexes = [
                /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/,
                /^([01]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/,
                /^(0?[1-9]|1[0-2]):[0-5][0-9] [aApP][mM]$/,
                /^(0?[1-9]|1[0-2]):[0-5][0-9]:[0-5][0-9] [aApP][mM]$/,
            ];

            for (let regex of regexes) {
                if (regex.test(timeSequence)) {
                    return timeSequence;
                }
            }

            return null;
        },
        show() {
            this.element.timepicker("showWidget");
        },
    },
    watch: {
        value: function(value) {
            this.time = value;
        },
        time: function(value) {
            this.time = value;

            if (this.minTime && moment(this.time, this.format).isBefore(moment(this.minTime, this.format))) {
                this.time = this.minTime;
            }
            if (this.maxTime && moment(this.time, this.format).isAfter(moment(this.maxTime, this.format))) {
                this.time = this.maxTime;
            }

            this.element.timepicker("setTime", this.time);
        },
        limitStartTime: function(value) {
            if (![null, undefined, ""].includes(value)) this.minTime = this.validate(value);
        },
        limitEndTime: function(value) {
            if (![null, undefined, ""].includes(value)) this.maxTime = this.validate(value);
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
