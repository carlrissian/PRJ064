<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <!-- Vue Multiselect Doc oficial: https://vue-multiselect.js.org/#sub-getting-started -->
        <multiselect
            @input="onInputChange"
            @change="onChange"
            ref="multiselect"
            :name="name"
            :id="id"
            :readonly="readonly"
            :disabled="disabled"
            :required="required"
            v-model="selection"
            :options="options"
            multiple
            :searchable="searchable"
            :preserve-search="searchable"
            :close-on-select="false"
            :placeholder="placeholder"
            label="text"
            track-by="text"
            :select-label="$t('select')"
            :selectedLabel="$t('selected')"
            :deselect-label="$t('remove')"
            group-select
            group-label="allOptions"
            group-values="data"
            :selectGroupLabel="$t('selectAll')"
            :deselectGroupLabel="$t('pressEnterToDeselect')"
            :limit="displayOptionsLimit"
        >
        </multiselect>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
    name: "ErpMultiSelectFilter",
    components: {
        Multiselect,
    },
    props: {
        name: String,
        id: String,
        value: [Number, String, Array, Object],
        displayOptionsLimit: {
            type: Number,
            default: 1,
        },
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
        searchable: {
            type: Boolean,
            default: true,
        },
        url: {
            type: String,
            required: false,
            default: null,
        },
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
            options: [
                {
                    allOptions: this.$t("allOptions"),
                    data: [],
                },
            ],
        };
    },
    created() {
        if (this.url) {
            this.fetchOptions();
        } else {
            this.options[0].data = this.manualOptions;
        }
    },
    computed: {
        dataSizeComputed() {
            return this.dataSize + 1 || this.optionsArray.length + 1;
        },
    },
    methods: {
        onInputChange(e) {
            this.$emit("onInputChangeMultiselect", e);
            this.$emit("updatedMultiselect", this.selection);
        },
        onChange(e) {
            this.$emit("onChangeMultiselect", e);
            this.$emit("updatedMultiselect", this.selection);
        },
        async fetchOptions() {
            this.selection = null;

            this.$axios
                .get(this.url)
                .then((response) => {
                    console.log(`Fetch ${this.url} options: `, response);
                    this.options[0].data = [];
                    if (response.data.length > 0) {
                        response.data.map((option) => {
                            this.returnObject
                                ? this.options[0].data.push({ text: option.name, value: option })
                                : this.options[0].data.push({ text: option.name, value: option.id });
                        });
                    }
                })
                .catch((e) => {
                    console.error(e);
                    this.options[0].data = [];
                });
        },
    },
    watch: {
        value: function (value) {
            this.selection = value;
        },
        manualOptions: function (value) {
            this.options[0].data = value;
        },
    },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.multiselect__tag {
    background: #48465b;
}

.multiselect__tag-icon:after {
    color: #ffffff !important;
}

.multiselect__tag-icon:focus,
.multiselect__tag-icon:hover {
    background: #48465b !important;
}

.multiselect__tag-icon:focus:after,
.multiselect__tag-icon:hover:after {
    color: #ffffff !important;
}

.multiselect__option--highlight,
.multiselect__option--highlight::after {
    background-color: #48465b;
}
</style>
