<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <!-- BootstrapVue Form Input Doc oficial: https://bootstrap-vue.org/docs/components/form-input -->
        <b-form-input
            @input="onInputChange"
            @change="onChange"
            @update="onUpdate"
            @blur="onBlur"
            ref="input"
            :name="name"
            :id="id"
            type="number"
            :min="min"
            :max="max"
            :step="step"
            :placeholder="placeholder ? placeholder : label"
            :autocomplete="autocomplete ? 'on' : 'off'"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model.lazy="data"
        />
    </div>
</template>

<script>
export default {
    name: "ErpInputNumberFilter",
    props: {
        name: String,
        id: String,
        value: [Number, String],
        min: Number,
        max: Number,
        step: [Number, String],
        numOfDecimals: Number,
        label: String,
        placeholder: {
            type: String,
            default: null,
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
            data: null,
        };
    },
    methods: {
        onInputChange(e) {
            this.$emit("onInputChangeInputNumber", e);
        },
        onChange(e) {
            if (this.data < this.min) this.data = this.min;
            if (this.data > this.max) this.data = this.max;
            if (this.data % 1 !== 0 && this.numOfDecimals) {
                this.data = parseFloat(this.data).toFixed(this.numOfDecimals);
            }

            this.$emit("onChangeInputNumber", e);
        },
        onUpdate(e) {
            this.$emit("updatedInputNumber", this.data);
        },
        onBlur(e) {
            this.$emit("onBlurInputNumber", e);
        },
    },
    watch: {
        value: function (value) {
            if (value % 1 !== 0 && this.numOfDecimals) {
                this.data = parseFloat(value).toFixed(this.numOfDecimals);
            } else {
                this.data = value;
            }
        },
    },
};
</script>

<style></style>
