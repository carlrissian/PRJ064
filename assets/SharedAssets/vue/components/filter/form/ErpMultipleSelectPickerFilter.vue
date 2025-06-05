<template>
    <div :class="divClass">
        <div>
            <label :class="labelClass" :for="id" v-text="label"></label>
            <div>
                <select
                    @change="onChange"
                    @blur="onBlur"
                    :name="name"
                    :ref="reference"
                    :id="id"
                    class="form-control kt-selectpicker"
                    multiple
                    :readonly="readonly"
                    :disabled="disabled"
                    :required="required"
                    v-model="selection"
                    :data-size="dataSizeComputed"
                    data-live-search="true"
                >
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
        </div>
    </div>
</template>

<script>
import Axios from "axios";

export default {
    name: "ErpMultipleSelectPickerFilter",
    props: {
        name: String,
        id: String,
        reference: {
            type: String,
            default: "select",
        },
        value: {
            type: Array,
            default: function() {
                return [];
            },
        },
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
        // Bloquear ciertos elementos
        disabledOptions: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            element: null,
            selection: [],
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
            this.$emit("onBlurMultipleSelectPicker", e);
        });

        this.element.on("changed.bs.select", (e, clickedIndex, isSelected, previousValue) => {
            this.$emit("onChangeMultipleSelectPicker", e, clickedIndex, isSelected, previousValue, this.selection);
        });
    },
    updated() {
        this.$nextTick(function() {
            this.element.selectpicker("refresh");
        });
    },
    computed: {
        dataSizeComputed() {
            return this.dataSize || this.optionsArray.length;
        },
    },
    methods: {
        onChange(e) {
            this.$emit("updatedMultipleSelectPicker", this.selection);
        },
        onBlur(e) {
            this.$emit("onBlurMultipleSelectPicker", e);
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
        selection: function() {
            if (this.disabledOptions) {
                this.optionsArray.forEach((opt) => {
                    this.selection.forEach((item) => {
                        if (opt.id === item.id && item?.disabled) {
                            const option = document.querySelector(
                                `#${this.id} option[value="${this.returnObject ? opt : opt.id}"]`
                            );
                            option.disabled = true;
                        }
                    });
                });
            }
        },
        options: function(options) {
            this.optionsArray = options;
        },
    },
};
</script>

<style></style>
