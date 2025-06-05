<template>
    <div :class="divClass">
        <label :class="labelClass" :for="id" v-text="label"></label>
        <multiselect
            @input="onInputChange"
            :name="name"
            :ref="reference"
            :id="id"
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
    name: "ErpMultiSelect",
    components: {
        Multiselect,
    },
    props: {
        name: String,
        id: String,
        reference: {
            type: String,
            default: "multiselect",
        },
        value: [Number, String, Array, Object],
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
            default: false,
        },
        dataSize: {
            type: Number,
            default: 0,
        },
        divClass: {
            type: String,
            default: null,
        },
        labelClass: {
            type: String,
            default: "control-label",
        },
        displayOptionsLimit: {
            type: Number,
            default: 1,
        },
        returnObject: {
            type: Boolean,
            default: false,
        },
        url: String,
    },
    data() {
        return {
            element: null,
            selection: this.value,
            options: [
                {
                    allOptions: this.$t("allOptions"),
                    data: [],
                },
            ],
        };
    },
    created() {
        this.fetchOptions();
    },
    methods: {
        onInputChange(e) {
            this.$emit("onInputChangeMultiselect", e);
        },
        onChange(e) {
            this.$emit("onChangeMultiselect", e);
            this.$emit("updatedMultiselect", this.selection);
        },
        async fetchOptions() {
            this.$axios
                .get(this.url)
                .then((response) => {
                    console.log(`Fetch ${this.url} options: `, response);
                    this.options[0].data = [];
                    // if (response.data?.length > 0) {
                    //     response.data.map((option) => {
                    //         this.returnObject
                    //             ? this.options[0].data.push({ text: option.name, value: option })
                    //             : this.options[0].data.push({ text: option.name, value: option.id });
                    //     });
                    // }
                    if (response.data.data?.length > 0) {
                        response.data.data.map((option) => {
                            this.returnObject
                                ? this.options[0].data.push({ text: option.name, value: option })
                                : this.options[0].data.push({ text: option.name, value: option.id });
                        });
                    }
                })
                .catch((e) => {
                    console.error(e);
                });
        },
    },
    watch: {
        value: function (value) {
            this.selection = value;
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
