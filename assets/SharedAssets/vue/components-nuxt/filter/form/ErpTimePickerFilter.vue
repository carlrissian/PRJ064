<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <!-- BootstrapVue Form Timepicker Doc oficial: https://bootstrap-vue.org/docs/components/form-timepicker -->
        <b-form-timepicker
            @input="onInputChange"
            @blur="onBlur"
            ref="timepicker"
            :name="name"
            :id="id"
            :placeholder="placeholder"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model="time"
            :locale="$i18n.locale"
            reset-button
        ></b-form-timepicker>
    </div>
</template>

<script>
export default {
    name: "ErpTimePickerFilter",
    props: {
        name: String,
        id: String,
        value: {
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
        placeholder: {
            type: String,
            // TODO o usamos traducción o se deja con formato
            default() {
                return this.localeFormat;
                // return this.$t("chooseAnHour");
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
            time: this.value,
            minTime: this.limitStartTime,
            maxTime: this.limitEndTime,
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
        onInputChange(e) {
            this.$emit("onInputChangeTimePicker", e);
            this.$emit("uptimedTimePicker", this.time);
        },
        onBlur(e) {
            this.$emit("onBlurTimePicker", e);
            this.$emit("uptimedTimePicker", this.time);
        },
        validate(time) {
            return this.$moment(time, this.format).isValid() ? this.$moment(time, this.format).format(this.format) : null;
        },
    },
    watch: {
        value: function (value) {
            this.time = this.validate(value);
        },
        time: function (value) {
            this.time = value;

            if (this.minTime && this.$moment(this.time, this.format).isBefore(this.$moment(this.minTime, this.format))) {
                this.time = this.minTime;
            }
            if (this.maxTime && this.$moment(this.time, this.format).isAfter(this.$moment(this.maxTime, this.format))) {
                this.time = this.maxTime;
            }
        },
        limitStartTime: function (time) {
            this.minTime = this.validate(time);
        },
        limitEndTime: function (time) {
            this.maxTime = this.validate(time);
        },
    },
};
</script>

<style></style>
