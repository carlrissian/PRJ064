<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <div :class="{ 'input-group': inputGroup }">
            <div v-if="inputGroup" class="input-group-prepend">
                <slot name="prepend"></slot>
            </div>
            <input
                @input="onInputChange"
                @change="onChange"
                @blur="onBlur"
                :type="hidden ? 'hidden' : 'text'"
                :maxlength="maxLength"
                :pattern="regex"
                :name="name"
                :ref="reference"
                :id="id"
                class="form-control"
                :placeholder="placeholder ? placeholder : label"
                :autocomplete="autocomplete ? 'on' : 'off'"
                :autofocus="autofocus"
                :readonly="readonly"
                :disabled="disabled"
                :required="required"
                v-model="data"
            />
            <div v-if="inputGroup" class="input-group-apend">
                <slot name="apend"></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ErpInputBaseFilter",
    props: {
        name: String,
        id: String,
        reference: {
            type: String,
            default: "input",
        },
        value: {
            type: [String, Number, Boolean, Object, Array],
            default: null,
        },
        maxLength: Number,
        regex: String,
        label: String,
        placeholder: {
            type: String,
            default: null,
        },
        autocomplete: {
            type: Boolean,
            default: false,
        },
        autofocus: {
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
        hidden: {
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
        inputGroup: {
            type: Boolean,
            default: false,
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
            this.$emit("onInputChangeInput", e);
        },
        onChange(e) {
            this.$emit("onChangeInput", e);
            this.$emit("updatedInput", this.data);
        },
        onBlur(e) {
            this.$emit("onBlurInput", e);
        },
    },
    watch: {
        value: function(value) {
            this.data = value;
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
