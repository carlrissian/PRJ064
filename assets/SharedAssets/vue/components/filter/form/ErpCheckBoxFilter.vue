<template>
    <fragment>
        <div :class="divClass">
            <div>
                <label :class="labelClass" :for="id">
                    <input
                        @change="onChange"
                        type="checkbox"
                        :name="name"
                        :ref="reference"
                        :id="id"
                        class="form-control"
                        :value="value"
                        :readonly="readonly"
                        :disabled="disabled"
                        :required="required"
                        v-model="isChecked"
                    />
                    <span></span>
                    {{ label }}
                </label>
            </div>
        </div>
    </fragment>
</template>

<script>
export default {
    name: "ErpCheckBoxFilter",
    props: {
        name: String,
        id: String,
        reference: {
            type: String,
            default: "checkbox",
        },
        value: [String, Number, Boolean, Object, Array],
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
            element: null,
            isChecked: this.checked,
        };
    },
    methods: {
        onChange(e) {
            this.$emit("onChangeCheckBox", e);
            this.$emit("updatedCheckBox", this.isChecked);
        },
    },
    watch: {
        checked() {
            this.isChecked = this.checked;
        },
    },
};
</script>

<style></style>
