<template>
    <div :class="'flex-center ' + divClass">
        <!-- BootstrapVue Form Checkbox Doc oficial: https://bootstrap-vue.org/docs/components/form-checkbox -->
        <b-form-checkbox
            @change="onChange"
            ref="checkbox"
            :name="name"
            :id="id"
            :value="checkedValue"
            :unchecked-value="uncheckedValue"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model="isChecked"
        >
            {{ label }}
        </b-form-checkbox>
    </div>
</template>

<script>
export default {
    name: "ErpCheckBoxFilter",
    props: {
        name: String,
        id: String,
        useValues: {
            type: Boolean,
            default: false,
        },
        checkedValue: {
            type: [String, Number, Boolean, Object, Array],
            required: false,
            default: true,
        },
        uncheckedValue: {
            type: [String, Number, Boolean, Object, Array],
            required: false,
            default: false,
        },
        checked: {
            type: Boolean,
            default: false,
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
            default: "kt-checkbox control-label",
        },
    },
    data() {
        return {
            isChecked: null,
        };
    },
    methods: {
        onChange(e) {
            this.$emit("onChangeCheckBox", e);
            this.$emit("updatedCheckBox", this.isChecked);
        },
    },
    watch: {
        checked: function (value) {
            this.isChecked = value;
        },
    },
};
</script>

<style>
.flex-center {
    display: flex;
    flex-wrap: nowrap;
    justify-content: flex-start;
    align-items: center;
}
</style>
