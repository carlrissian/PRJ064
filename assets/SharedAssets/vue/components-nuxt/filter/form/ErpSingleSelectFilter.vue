<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <!-- BootstrapVue Form Select Doc oficial: https://bootstrap-vue.org/docs/components/form-select -->
        <b-form-select
            @input="onInputChange"
            @change="onChange"
            ref="select"
            :name="name"
            :id="id"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model="selection"
            :data-size="dataSizeComputed"
            data-live-search="true"
        >
            <b-form-select-option :value="null" v-text="placeholder"></b-form-select-option>
            <b-form-select-option
                v-if="options.length > 0"
                v-for="option in options"
                :key="option"
                :value="option.value"
                v-text="option.text"
            ></b-form-select-option>
            <!-- Dentro del slot se puede usar <b-form-select-option>, <b-form-select-option-group> y demás -->
            <slot name="manual-options"></slot>
        </b-form-select>
    </div>
</template>

<script>
export default {
    name: "ErpSingleSelectFilter",
    props: {
        name: String,
        id: String,
        value: [Number, String, Array, Object],
        returnObject: {
            type: Boolean,
            default: false,
        },
        label: String,
        placeholder: {
            type: String,
            default: function () {
                return this.$t("chooseAnOption");
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
        url: {
            type: String,
            required: false,
            default: null,
        },
        // Estructura a recibir: https://bootstrap-vue.org/docs/components/form-select#options-property
        manualOptions: {
            type: Array,
            required: false,
            default: null,
        },
        dataSize: {
            type: Number,
            default: 10,
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
            selection: null,
            options: [],
        };
    },
    created() {
        if (this.url) this.fetchOptions();
    },
    computed: {
        dataSizeComputed() {
            return this.dataSize + 1 || this.optionsArray.length + 1;
        },
    },
    methods: {
        onInputChange(e) {
            this.$emit("onInputChangeSelect", e);
            this.$emit("updatedSelect", this.selection);
        },
        onChange(e) {
            this.$emit("onChangeSelect", e);
            this.$emit("updatedSelect", this.selection);
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
            this.selection = value;
        },
        manualOptions: function (value) {
            this.options = value;
        },
    },
};
</script>

<style></style>
