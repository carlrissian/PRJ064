<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <!-- BootstrapVue Form Timepicker Doc oficial: https://bootstrap-vue.org/docs/components/form-timepicker -->

        <div class="d-flex">
            <b-form-timepicker
                @input="onInputChange($event, TIME_FROM)"
                @blur="onBlur($event, TIME_FROM)"
                ref="timepickerFrom"
                :name="name + TIME_FROM"
                :id="id + TIME_FROM"
                class="mb-2"
                :placeholder="$t('from')"
                :readonly="readonly"
                :disabled="disabled"
                :required="required"
                v-model="times.from"
                :locale="$i18n.locale"
                reset-button
            ></b-form-timepicker>

            <span class="mt-3 ml-1 mr-1">-</span>

            <b-form-timepicker
                @input="onInputChange($event, TIME_TO)"
                @blur="onBlur($event, TIME_TO)"
                ref="timepickerTo"
                :name="name + TIME_TO"
                :id="id + TIME_TO"
                class="mb-2"
                :placeholder="$t('to')"
                :readonly="readonly"
                :disabled="requireDisableTo ? disableTo : disabled"
                :required="required"
                v-model="times.to"
                :locale="$i18n.locale"
                reset-button
            ></b-form-timepicker>
        </div>
    </div>
</template>

<script>
export const TIME_FROM = "From";
export const TIME_TO = "To";

export default {
    name: "ErpTimeRangeFilter",
    props: {
        name: String, // INFO no es necesario poner coletilla de From o To, se añade automáticamente.
        id: String,
        valueFrom: {
            type: String,
            required: false,
            default: null,
        },
        valueTo: {
            type: String,
            required: false,
            default: null,
        },
        limitStartTime: {
            type: String,
            required: false,
            default: null,
        },
        limitEndTime: {
            type: String,
            required: false,
            default: null,
        },
        // TODO https://bootstrap-vue.org/docs/components/form-timepicker#understanding-the-hourcycle
        hourCycle: {
            type: String,
            required: false,
        },
        label: String,
        readonly: {
            type: Boolean,
            default: false,
        },
        requireDisableTo: {
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
    // FIXME las variables sólo captan valores aqui dentro y en v-model
    data() {
        return {
            TIME_FROM,
            TIME_TO,
            times: {
                from: this.valueFrom,
                to: this.valueTo,
            },
            min: {
                from: this.limitStartTime,
                to: this.limitEndTime,
            },
            max: {
                from: this.limitStartTime,
                to: this.limitEndTime,
            },
            disableTo: true,
        };
    },
    computed: {
        format() {
            let format = null;
            this.$i18n.availableLocales.forEach((locale) => {
                if (this.$i18n.locale === locale) {
                    format = this.$moment().locale(locale).localeData().longDateFormat("LT");
                }
            });
            return format;
        },
        localeFormat() {
            let format = null;
            this.$i18n.availableLocales.forEach((locale) => {
                if (this.$i18n.locale === locale) {
                    format = this.$moment().locale(locale).localeData().longDateFormat("LT").includes("A")
                        ? "h:mm AM/PM"
                        : "hh:mm";
                }
            });
            return format;
        },
    },
    methods: {
        onInputChange(e, source) {
            this.$emit(`onInputChangeTimePicker${source}`, e);
            this.$emit(`updatedTimePicker${source}`, this.times[String(source).toLowerCase()]);
        },
        onBlur(e, source) {
            this.$emit(`onBlurTimePicker${source}`, e);
            this.$emit(`updatedTimePicker${source}`, this.times[String(source).toLowerCase()]);
        },
        validate(time) {
            return this.$moment(time, this.format).isValid() ? this.$moment(time, this.format).format(this.format) : null;
        },
    },
    // FIXME no funciona nada del watch
    watch: {
        valueFrom: function (value) {
            this.times.from = this.validate(value);
            if (this.requireDisableTo) this.disableTo = ["", null, undefined].includes(this.times.from);
            if (["", null, undefined].includes(this.times.from) && this.requireDisableTo) this.times.to = null;
        },
        valueTo: function (value) {
            this.times.to = this.validate(value);
        },
        "times.from": function (value) {
            this.times.from = this.validate(value);
            if (this.requireDisableTo) this.disableTo = ["", null, undefined].includes(this.times.from);
            if (["", null, undefined].includes(this.times.from) && this.requireDisableTo) this.times.to = null;

            if (this.min.from && this.$moment(this.times.from, this.format).isBefore(this.$moment(this.min.from, this.format))) {
                this.times.from = this.min.from;
            }
            if (this.max.from && this.$moment(this.times.from, this.format).isAfter(this.$moment(this.max.from, this.format))) {
                this.times.from = this.max.from;
            }
            if (
                this.times.from !== null &&
                this.times.to !== null &&
                this.$moment(this.times.from).isAfter(this.$moment(this.times.to))
            ) {
                this.times.from = this.times.to;
            }
        },
        "times.to": function (value) {
            this.times.to = this.validate(value);

            if (this.min.to && this.$moment(this.times.to, this.format).isBefore(this.$moment(this.min.to, this.format))) {
                this.times.to = this.min.to;
            }
            if (this.max.to && this.$moment(this.times.to, this.format).isAfter(this.$moment(this.max.to, this.format))) {
                this.times.to = this.max.to;
            }
            if (
                this.times.to !== null &&
                this.times.from !== null &&
                this.$moment(this.times.to).isBefore(this.$moment(this.times.from))
            ) {
                this.times.to = this.times.from;
            }
        },
        limitStartTime: function (time) {
            this.min.from = this.validate(time);
            this.min.to = this.validate(time);
        },
        limitEndTime: function (time) {
            this.max.from = this.validate(time);
            this.max.to = this.validate(time);
        },
    },
};
</script>

<style></style>
