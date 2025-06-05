<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <div>
            <input
                @input="onInputChange"
                @change="onChange"
                @blur="onBlur"
                type="number"
                :min="min"
                :max="max"
                :step="step"
                :name="name"
                :ref="reference"
                :id="id"
                class="form-control"
                :placeholder="placeholder ? placeholder : label"
                :autocomplete="autocomplete ? 'on' : 'off'"
                :readonly="readonly"
                :disabled="disabled"
                :required="required"
                v-model.lazy="data"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: "ErpInputNumberFilter",
    props: {
        name: String,
        id: String,
        reference: {
            type: String,
            default: "input",
        },
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
            element: null,
            data: this.value,
        };
    },
    methods: {
        onInputChange(e) {
            this.$emit("onChangeInputNumber", e);
        },
        onChange(e) {
            if (this.data < this.min) this.data = this.min;
            if (this.data > this.max) this.data = this.max;
            if (this.data % 1 !== 0 && this.numOfDecimals) {
                this.data = parseFloat(this.data).toFixed(this.numOfDecimals);
            }

            this.$emit("onChangeInputNumber", e);
            this.$emit("updatedInputNumber", this.data);
        },
        onBlur(e) {
            this.$emit("onBlurInputNumber", e);
        },
    },
    watch: {
        value() {
            if (this.value % 1 !== 0 && this.numOfDecimals) {
                this.data = parseFloat(this.value).toFixed(this.numOfDecimals);
            } else {
                this.data = this.value;
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
