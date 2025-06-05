<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <textarea
            @input="onInputChange"
            @change="onChange"
            :name="name"
            :ref="reference"
            :id="id"
            class="form-control"
            :cols="cols"
            :rows="rows"
            :wrap="wrap"
            :placeholder="placeholder ? placeholder : label"
            :autofocus="autofocus"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model.lazy="data"
        ></textarea>
    </div>
</template>

<script>
export default {
    name: "TextArea",
    props: {
        name: String,
        id: String,
        reference: String,
        value: [String, Number, Boolean, Object, Array],
        cols: Number,
        rows: Number,
        wrap: String,
        label: String,
        placeholder: {
            type: String,
            default: null,
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
            this.$emit("onInputChangeTextArea", e);
        },
        onChange(e) {
            this.$emit("onChangeTextArea", e);
            this.$emit("updatedTextArea", this.data);
        },
    },
    watch: {
        value() {
            this.data = this.value;
        },
    },
};
</script>

<style></style>
