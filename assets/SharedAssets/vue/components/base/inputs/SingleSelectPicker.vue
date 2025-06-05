<template>
    <div :class="divClass">
        <label v-if="label" :class="labelClass" :for="id" v-text="label"></label>
        <select
            @change="onChange"
            @blur="onBlur"
            :name="name"
            :ref="reference"
            :id="id"
            class="form-control kt-selectpicker"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model="selection"
            :data-size="dataSizeComputed"
            data-live-search="true"
        >
            <!-- FIXME el dataSize se vuelve loco al añadir este valor default -->
            <option :value="null" v-text="placeholder"></option>
            <option
                v-if="optionsArray.length > 0"
                v-for="item in optionsArray"
                :key="item.id"
                :value="returnObject ? item : item.id"
                v-text="item.name"
            ></option>
            <slot></slot>
        </select>
    </div>
</template>

<script>
import Axios from "axios";

export default {
    name: "SingleSelectPicker",
    props: {
        name: String,
        id: String,
        reference: {
            type: String,
            default: "select",
        },
        value: [Number, String, Boolean, Array, Object],
        url: String,
        options: {
            type: Array,
            default: function() {
                return [];
            },
        },
        returnObject: {
            type: Boolean,
            default: false,
        },
        label: String,
        placeholder: {
            type: String,
            default: "Select an option",
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
            element: null,
            selection: this.value,
            optionsArray: this.options,
        };
    },
    created() {
        if (this.url) this.fetchOptions();
    },
    mounted() {
        let config = {
            noneSelectedText: this.placeholder,
            liveSearch: true,
            actionsBox: true,
        };

        this.element = $(`#${this.id}`);
        this.element.selectpicker(config);

        this.element.on("hidden.bs.select", (e) => {
            this.$emit("onBlurSelectPicker", e);
        });
    },
    updated() {
        this.$nextTick(function() {
            this.element.selectpicker("refresh");
        });
    },
    computed: {
        dataSizeComputed() {
            return this.dataSize + 1 || this.optionsArray.length + 1;
        },
    },
    methods: {
        onChange(e) {
            this.$emit("onChangeSelectPicker", e);
            this.$emit("updatedSelectPicker", this.selection);
        },
        onBlur(e) {
            this.$emit("onBlurSelectPicker", e);
        },
        fetchOptions: async function() {
            Axios.get(this.url)
                .then((response) => {
                    console.log(`Fetch ${this.url} options: `, response);
                    this.optionsArray = response.data?.length > 0 ? response.data : [];
                })
                .catch((e) => {
                    console.error(e);
                });
        },
    },
    watch: {
        value: function(value) {
            this.selection = value;
        },
        options: function(options) {
            this.optionsArray = options;
        },
    },
};
</script>

<style></style>
