<template>
    <div :class="divClass">
        <label v-if="label" :class="labelClass" :for="id" v-text="label"></label>

        <b-form-group
            v-if="validate"
            :id="`${id}-group`"
            :description="description"
            :valid-feedback="validFeedback"
            :invalid-feedback="invalidFeedback"
            :state="validate"
        >
            <b-form-input
                @input="onInputChange"
                @change="onChange"
                @blur="onBlur"
                :type="type"
                :maxlength="maxLength"
                :pattern="regex"
                :name="name"
                :ref="reference"
                :id="id"
                class="form-control"
                :size="size"
                :formatter="formatter"
                :list="datalistId"
                :placeholder="placeholder ? placeholder : label"
                :autocomplete="autocomplete ? 'on' : 'off'"
                :autofocus="autofocus"
                :readonly="readonly"
                :disabled="disabled"
                :required="required"
                v-model="data"
                :trim="trim"
            />
        </b-form-group>

        <b-form-input
            v-else
            @input="onInputChange"
            @change="onChange"
            @blur="onBlur"
            :type="type"
            :maxlength="maxLength"
            :pattern="regex"
            :name="name"
            :ref="reference"
            :id="id"
            class="form-control"
            :size="size"
            :formatter="formatter"
            :list="useDatalist ? `${id}-datalist` : null"
            :placeholder="placeholder ? placeholder : label"
            :autocomplete="autocomplete ? 'on' : 'off'"
            :autofocus="autofocus"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model="data"
            :trim="trim"
        />

        <datalist v-if="useDatalist" :id="`${id}-datalist`">
            <slot name="manual-options"></slot>
            <option
                v-if="options.length > 0"
                v-for="option in options"
                :key="option.value"
                :value="returnText ? option.text : option.value"
                v-text="option.text"
            ></option>
        </datalist>
    </div>
</template>

<script>
export default {
    name: "ErpInput",
    props: {
        name: String,
        id: String,
        reference: {
            type: String,
            default: "input",
        },
        type: {
            type: String,
            default: "text",
            validator: (value) => {
                return ["text", "email", "password", "search", "url", "tel", "hidden"].includes(value);
            },
        },
        value: [String, Number, Boolean, Object, Array],
        maxLength: Number,
        regex: String,
        label: String,
        size: {
            type: String,
            default: "md",
            validator: (value) => {
                return ["sm", "md", "lg"].includes(value);
            },
        },
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
        trim: {
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
        formatter: {
            type: Function,
            default: null,
        },
        validate: {
            type: Function,
            default: null,
        },
        description: {
            type: String,
            default: null,
        },
        validFeedback: {
            type: String,
            default: function () {
                return this.$t("common.input.valid");
            },
        },
        invalidFeedback: {
            type: Function,
            default: function () {
                return this.$t("common.input.invalid");
            },
        },
        useDatalist: {
            type: Boolean,
            default: false,
        },
        url: {
            type: String,
            required: false,
            default: null,
        },
        // Estructura a recibir: https://bootstrap-vue.org/docs/components/form-input#datalist-support
        manualOptions: {
            type: Array,
            required: false,
            default: null,
        },
        returnObject: {
            type: Boolean,
            default: false,
        },
        returnText: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            data: null,
            options: [],
        };
    },
    created() {
        if (this.url) this.fetchOptions();
    },
    methods: {
        onInputChange(e) {
            this.$emit("inputChange", e);
        },
        onChange(e) {
            this.$emit("change", e);
            this.$emit("updated", this.data);
        },
        onBlur(e) {
            this.$emit("blur", e);
        },
        async fetchOptions() {
            this.$axios
                .get(this.url)
                .then((response) => {
                    console.log(`Fetch ${this.url} options: `, response);
                    this.options = [];

                    if (response.data.length > 0) {
                        response.data.map((option) => {
                            this.returnObject
                                ? this.options.push({ text: option.name, value: option })
                                : this.options.push({ text: option.name, value: option.id });
                        });
                    }
                })
                .catch((error) => {
                    console.error(error.response);
                });
        },
    },
    watch: {
        value: function (value) {
            this.data = value;
        },
        manualOptions: {
            handler: function (value) {
                value?.map((option) => {
                    this.returnObject
                        ? this.options.push({ text: option.name || option.text, value: option })
                        : this.options.push({ text: option.name || option.text, value: option.id });
                });
            },
            immediate: true,
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
