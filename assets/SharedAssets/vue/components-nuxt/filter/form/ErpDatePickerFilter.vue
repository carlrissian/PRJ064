<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <!-- BootstrapVue Form Datepicker Doc oficial: https://bootstrap-vue.org/docs/components/form-datepicker -->
        <b-form-datepicker
            @input="onInputChange"
            @blur="onBlur"
            ref="datepicker"
            :name="name"
            :id="id"
            :min="min"
            :max="max"
            :placeholder="placeholder"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model="date"
            :locale="$i18n.locale"
            :date-format-options="dateFormatOptions"
            reset-button
        ></b-form-datepicker>
    </div>
</template>

<script>
export default {
    name: "ErpDatePickerFilter",
    props: {
        name: String,
        id: String,
        value: {
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
        placeholder: {
            type: String,
            // TODO o usamos traducción o se deja con formato
            default() {
                return this.format;
                // return this.$t("chooseADate");
            },
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
            date: null,
            min: null,
            max: null,
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
        onInputChange(e) {
            this.$emit("onInputChangeDatePicker", e);
            this.$emit("updatedDatePicker", this.date);
        },
        onBlur(e) {
            this.$emit("onBlurDatePicker", e);
            this.$emit("updatedDatePicker", this.date);
        },
    },
    watch: {
        value: function (value) {
            if (typeof value === "string") {
                this.date = new Date(value);
            }
            if (value instanceof Date) {
                this.date = value;
            }
        },
        limitStartDay: function (date) {
            if (typeof date === "string") {
                this.min = new Date(date);
            }
            if (date instanceof Date) {
                this.min = date;
            }
        },
        limitEndDay: function (date) {
            if (typeof date === "string") {
                this.max = new Date(date);
            }
            if (date instanceof Date) {
                this.max = date;
            }
        },
    },
};
</script>

<style></style>
