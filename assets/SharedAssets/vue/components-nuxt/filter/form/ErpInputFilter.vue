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
            type="text"
            :placeholder="placeholder ? placeholder : label"
            :autocomplete="autocomplete ? 'on' : 'off'"
            :formatter="formatter"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model="data"
        />
    </div>
</template>

<script>
export default {
    name: "ErpInputFilter",
    props: {
        name: String,
        id: String,
        value: [Number, String],
        label: String,
        placeholder: {
            type: String,
            default: null,
        },
        autocomplete: {
            type: Boolean,
            default: false,
        },
        // https://bootstrap-vue.org/docs/components/form-input#formatter-support
        formatter: {
            type: Function,
            required: false,
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
            this.$emit("onInputChangeInput", e);
        },
        onChange(e) {
            this.$emit("onChangeInput", e);
        },
        onUpdate(e) {
            this.$emit("updatedInput", this.data);
        },
        onBlur(e) {
            this.$emit("onBlurInput", e);
        },
    },
    watch: {
        value: function (value) {
            this.data = value;
        },
    },
};
</script>

<style></style>
