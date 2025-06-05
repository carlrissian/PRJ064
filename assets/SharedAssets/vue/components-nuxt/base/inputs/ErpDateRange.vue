<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <!-- BootstrapVue Form Datepicker Doc oficial: https://bootstrap-vue.org/docs/components/form-datepicker -->
        <div class="d-flex">
            <b-form-datepicker
                @input="onInputChange($event, DATE_FROM)"
                @blur="onBlur($event, DATE_FROM)"
                ref="datepickerFrom"
                :name="name + DATE_FROM"
                :id="id + DATE_FROM"
                class="mb-2"
                :min="min.from"
                :max="max.from"
                :placeholder="$t('from')"
                :readonly="readonly"
                :disabled="disabled"
                :required="required"
                v-model="dates.from"
                :locale="$i18n.locale"
                :date-format-options="dateFormatOptions"
                value-as-date
                reset-button
            ></b-form-datepicker>

            <span class="mt-3 ml-1 mr-1">-</span>

            <b-form-datepicker
                @input="onInputChange($event, DATE_TO)"
                @blur="onBlur($event, DATE_TO)"
                ref="datepickerTo"
                :name="name + DATE_TO"
                :id="id + DATE_TO"
                class="mb-2"
                :min="min.to"
                :max="max.to"
                :placeholder="$t('to')"
                :readonly="readonly"
                :disabled="requireDisableTo ? disableTo : disabled"
                :required="required"
                v-model="dates.to"
                :locale="$i18n.locale"
                :date-format-options="dateFormatOptions"
                value-as-date
                reset-button
            ></b-form-datepicker>
        </div>
    </div>
</template>

<script>
export const DATE_FROM = "From";
export const DATE_TO = "To";

export default {
    name: "ErpDateRange",
    props: {
        name: String, // INFO no es necesario poner coletilla de From o To, se añade automáticamente.
        id: String,
        valueFrom: {
            type: [Date, String],
            validator: (date) => {
                return date instanceof Date || (typeof date === "string" && !isNaN(Date.parse(date)));
            },
        },
        valueTo: {
            type: [Date, String],
            validator: (date) => {
                return date instanceof Date || (typeof date === "string" && !isNaN(Date.parse(date)));
            },
        },
        // https://bootstrap-vue.org/docs/components/form-datepicker#minimum-and-maximum-dates
        limitStartDay: {
            type: [Date, String],
            required: false,
            validator: (date) => {
                return date instanceof Date || (typeof date === "string" && !isNaN(Date.parse(date)));
            },
            default: null,
        },
        limitEndDay: {
            type: [Date, String],
            required: false,
            validator: (date) => {
                return date instanceof Date || (typeof date === "string" && !isNaN(Date.parse(date)));
            },
            default: null,
        },
        // https://bootstrap-vue.org/docs/components/form-datepicker#date-string-format
        dateFormatOptions: {
            type: Object,
            default: () => {
                return { year: "numeric", month: "2-digit", day: "2-digit" };
                // return { year: "numeric", month: "numeric", day: "numeric" };
            },
        },
        label: String,
        readonly: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        requireDisableTo: {
            type: Boolean,
            default: false,
        },
        required: {
            type: Boolean,
            default: false,
        },
        // valueAsDate: {
        //     type: Boolean,
        //     default: true,
        // },
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
            DATE_FROM,
            DATE_TO,
            dates: {
                from: null,
                to: null,
            },
            min: {
                from: null,
                to: null,
            },
            max: {
                from: null,
                to: null,
            },
            disableTo: true,
        };
    },
    computed: {
        format() {
            let format = null;
            this.$i18n.availableLocales.forEach((locale) => {
                if (this.$i18n.locale === locale) {
                    format = this.$moment()
                        .locale(locale)
                        .localeData()
                        .longDateFormat("L")
                        .replace(/D/g, "d")
                        .replace(/M/g, "m")
                        .replace(/Y/g, "y");
                }
            });
            return format;
        },
    },
    methods: {
        onInputChange(e, source) {
            this.$emit(`onInputChangeDatePicker${source}`, e);
            this.$emit(
                `updatedDatePicker${source}`,
                this.$moment(this.dates[String(source).toLowerCase()]).format(String(this.format).toUpperCase())
            );
        },
        onBlur(e, source) {
            this.$emit(`onBlurDatePicker${source}`, e);
            this.$emit(
                `updatedDatePicker${source}`,
                this.$moment(this.dates[String(source).toLowerCase()]).format(String(this.format).toUpperCase())
            );
        },
    },
    watch: {
        valueFrom: function (value) {
            if (this.requireDisableTo) this.disableTo = ["", null, undefined].includes(value);
            if (["", null, undefined].includes(value)) {
                this.dates.from = null;
                if (this.requireDisableTo) this.dates.to = null;
            }
            if (typeof value === "string") {
                this.dates.from = new Date(value);
            }
            if (value instanceof Date) {
                this.dates.from = value;
            }
        },
        valueTo: function (value) {
            if (["", null, undefined].includes(value)) {
                this.dates.to = null;
            }
            if (typeof value === "string") {
                this.dates.to = new Date(value);
            }
            if (value instanceof Date) {
                this.dates.to = value;
            }
        },
        "dates.from": function (value) {
            if (this.requireDisableTo) this.disableTo = ["", null, undefined].includes(value);
            this.min.to = !["", null, undefined].includes(value) ? value : this.limitStartDay;
            if (["", null, undefined].includes(value) && this.requireDisableTo) this.dates.to = null;
        },
        "dates.to": function (value) {
            this.max.from = !["", null, undefined].includes(value) ? value : this.limitEndDay;
        },
        limitStartDay: function (date) {
            if (typeof date === "string") {
                this.min.from = new Date(date);
                this.min.to = new Date(date);
            }
            if (date instanceof Date) {
                this.min.from = date;
                this.min.to = date;
            }
        },
        limitEndDay: function (date) {
            if (typeof date === "string") {
                this.max.from = new Date(date);
                this.max.to = new Date(date);
            }
            if (date instanceof Date) {
                this.max.from = date;
                this.max.to = date;
            }
        },
    },
};
</script>

<style></style>
