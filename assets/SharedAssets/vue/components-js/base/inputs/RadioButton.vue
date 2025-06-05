<template>
    <fragment>
        <div v-if="divClass" :class="divClass">
            <label :class="labelClass" :for="id">
                <input
                    @change="onChange"
                    type="radio"
                    :name="name"
                    :ref="reference"
                    :id="id"
                    :value="value"
                    :disabled="disabled"
                    :required="required"
                    v-model="isChecked"
                />
                {{ label }}
                <span></span>
            </label>
        </div>

        <label v-else :class="labelClass" :for="id">
            <input
                @change="onChange"
                type="radio"
                :name="name"
                :ref="reference"
                :id="id"
                :value="value"
                :disabled="disabled"
                :required="required"
                v-model="isChecked"
            />
            {{ label }}
            <span></span>
        </label>
    </fragment>
</template>

<script>
export default {
    name: "RadioButton",
    props: {
        name: String,
        id: String,
        reference: String,
        value: [String, Number, Boolean, Object, Array],
        checked: {
            type: Boolean,
            default: false,
        },
        label: String,
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
            default: "kt-radio",
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
            this.$emit("onChangeRadioButton", e);
            this.$emit("updatedRadioButton", this.isChecked);
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
