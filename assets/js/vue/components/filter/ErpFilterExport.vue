<template>
    <div class="row mb-5">
        <!-- Open/close button + delete filters -->
        <div class="col-md-6 col-sm-12 mb-3 filters">
            <button
                @click="collapsed = !collapsed"
                type="button"
                id="show-filters"
                class="btn btn-record"
                data-toggle="collapse"
                data-target="#collapse-filters"
                :aria-expanded="showFilters"
                aria-controls="collapse-filters"
            >
                {{ translations.filter }} <i class="ml-3" :class="collapsed ? 'fa fa-angle-up' : 'fa fa-angle-down'"></i>
            </button>

            <button
                v-show="!collapsed && selectedFilters.length > 0"
                @click="clear"
                type="button"
                class="btn btn-record"
                v-text="translations.filterButtonDeleteAll"
            ></button>
        </div>
        <!--  -->
        <div class="col-6 d-flex flex-row-reverse">
            <slot name="actions"></slot>
        </div>

        <!-- Chips -->
        <div v-if="!collapsed && selectedFilters.length > 0" id="filter-chips" class="col-12 d-inline filters">
            <button
                v-for="(item, index) in selectedFilters"
                :key="index"
                @click="removeItemFilter(item)"
                type="button"
                class="btn btn-sm btn-light btn-pill btn-filter-data"
                style="margin-bottom: 1em"
                :data-target="item.name"
            >
                {{ formatterChip(item) }}<i class="fa fa-times-circle fa-lg ml-3"></i>
            </button>
        </div>
        <!--  -->

        <!-- Collapse dropdown -->
        <div id="collapse-filters" class="col-12 filters collapse">
            <div class="kt-portlet kt-portlet--solid-light mb-0">
                <form @submit.prevent="search" id="form-search" autocomplete="off">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="fa fa-filter"></i></span>
                            <h3 class="kt-portlet__head-title" v-text="translations.filterTitle"></h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <div class="row">
                            <slot></slot>
                        </div>
                    </div>

                    <div v-if="showButtons" class="kt-portlet__foot kt-portlet__foot--sm kt-align-right">
                        <button
                            @click="clear"
                            type="button"
                            class="btn btn-record"
                            v-text="translations.filterButtonDeleteAll"
                        ></button>
                        <button
                            v-if="showSearchButton"
                            type="submit"
                            class="btn btn-record"
                            v-text="translations.filterSearch"
                        ></button>
                    </div>
                </form>
            </div>
        </div>
        <!--  -->
    </div>
</template>

<script>
export default {
    name: "ErpFilterExport",
    components: {},
    props: {
        storeModuleName: {
            type: String,
            default: "erpFilter",
        },
        showFilters: {
            type: Boolean,
            default: false,
        },
        showButtons: {
            type: Boolean,
            default: true,
        },
        showSearchButton: {
            type: Boolean,
            default: true,
        },
        autoSubmit: {
            type: Boolean,
            default: true,
        },
        activateEnterKeySearch: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            translations: msg.filter,
            collapsed: false,
            submitted: false,
            selectedFilters: [],
            formFields: [],
            filters: {},
        };
    },
    mounted() {
        this.collapsed = this.showFilters;

        this.formFields = Array.from(
            document.querySelectorAll(`#collapse-filters #form-search input, #collapse-filters #form-search select`)
        ).filter((el) => el.getAttribute("type") !== "search");

        this.formFields.forEach((element) => {
            switch (element.type) {
                case "select-multiple":
                    $(element).on("changed.bs.select", () => {
                        this.saveFilters();
                    });
                    $(element).on("hidden.bs.select", () => {
                        this.saveFilters();
                    });
                    break;
                case "select-one":
                case "checkbox":
                case "text":
                default:
                    if (element.classList.contains("date")) {
                        $(element).on("changeDate", () => {
                            this.saveFilters();
                        });
                    }
                    element.addEventListener("change", () => {
                        this.saveFilters();
                    });
                    element.addEventListener("blur", () => {
                        this.saveFilters();
                    });
                    break;
            }
        });

        if (this.activateEnterKeySearch) {
            document.querySelector("#collapse-filters #form-search").addEventListener("keypress", (e) => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    this.searchButton();
                }
            });
        }
    },
    beforeDestroy() {
        this.$store.dispatch(`${this.storeModuleName}/removeFilters`);
    },
    destroyed() {
        if (this.activateEnterKeySearch) {
            document.querySelector("#collapse-filters #form-search").removeEventListener("keypress");
        }
    },
    computed: {},
    methods: {
        formatterChip(item) {
            if (item.type === "select") {
                return Array.isArray(item.value) ? `${item.name}: ${item.text.join(", ")}` : `${item.name}: ${item.text}`;
            }

            if (item.value instanceof Object) {
                return `${item.name}: ${item?.value["name"]}`;
            }

            if (typeof item.value === "boolean") {
                return `${item.name}: ${item.value ? this.translations.yes : this.translations.no}`;
            }

            return `${item.name}: ${item.value}`;
        },
        flush(item = null) {
            if (item) {
                this.selectedFilters = this.selectedFilters.filter((filter) => filter.name !== item.name);
                delete this.filters[item.name];
            } else {
                this.selectedFilters = [];
                this.filters = {};
            }
        },
        saveField(field) {
            if (!["", null, undefined].includes(field.value) && !this.selectedFilters.some((item) => item.name === field.name)) {
                if (!field.manualSave) {
                    this.filters[field.filterName] = field.value;
                    this.selectedFilters.push(field);
                }
            }
        },
        saveFilters() {
            this.flush();

            this.formFields.forEach((element) => {
                let field = {
                    type: null,
                    filterName: null,
                    name: null,
                    value: null,
                    text: null,
                    manualSave: false,
                };

                field.filterName = element.name;
                field.name =
                    element.parentElement.parentElement.querySelector("label")?.innerText ||
                    element.parentElement.parentElement.parentElement.querySelector("label")?.innerText;

                switch (element.type) {
                    case "select-one":
                        field.type = "select";
                        field.value = element.value;
                        field.text = element.options[element.selectedIndex].text;
                        break;
                    case "select-multiple":
                        field.type = "select";
                        field.value = Array.from(element.selectedOptions).map((option) => option.value);
                        field.value = field.value.length > 0 ? field.value : null;
                        field.text = Array.from(element.selectedOptions).map((option) => option.text);
                        break;
                    case "checkbox":
                        field.type = "check";
                        field.value = element.checked ? element.checked : null;
                        break;
                    case "text":
                    default:
                        field.value = element.value ? escape(element.value) : null;
                        break;
                }
                this.saveField(field);
            });
        },
        removeItemFilter(item) {
            this.flush(item);

            this.formFields.forEach((element) => {
                if (item.filterName === element.name) {
                    switch (element.type) {
                        case "select-one":
                        case "select-multiple":
                            Array.from(element.options).forEach((option) => (option.selected = false));
                            const title =
                                element.parentElement.parentElement.parentElement.querySelector("label")?.innerText ||
                                this.translations.nothingSelected;
                            element.nextSibling.title = title;
                            element.nextSibling.querySelector(".filter-option-inner-inner").innerText = title;
                            break;
                        case "checkbox":
                            if (element.checked) element.checked = false;
                            break;
                        case "text":
                        default:
                            element.value = null;
                            break;
                    }

                    this.$emit("filterDeleted", item.name);
                }
            });

            if (this.selectedFilters.length > 0 || this.autoSubmit) {
                this.$nextTick(function() {
                    this.search();
                });
            } else {
                this.submitted = false;
                this.$emit("filtersCleared", this.submitted);
            }
        },
        removeFilters() {
            this.flush();

            this.formFields.forEach((element) => {
                switch (element.type) {
                    case "select-one":
                    case "select-multiple":
                        Array.from(element.options).forEach((option) => (option.selected = false));
                        const title =
                            element.parentElement.parentElement.parentElement.querySelector("label")?.innerText ||
                            this.translations.nothingSelected;
                        element.nextSibling.title = title;
                        element.nextSibling.querySelector(".filter-option-inner-inner").innerText = title;
                        break;
                    case "checkbox":
                        if (element.checked) element.checked = false;
                        break;
                    case "text":
                    default:
                        element.value = null;
                        break;
                }
            });

            this.$emit("filtersCleared", this.submitted);

            if (this.autoSubmit) {
                this.$nextTick(function() {
                    this.search();
                });
            }
        },
        search() {
            this.collapsed = false;

            this.submitted = true;
            // Se añade este evento para cuando se requiera realizar alguna acción antes de enviar filtros y mostrar la tabla
            this.$emit("filtersSubmitted", this.submitted);

            this.saveFilters();

            this.$store.dispatch(`${this.storeModuleName}/removeFilters`);
            this.$store.dispatch(`${this.storeModuleName}/saveFilters`, this.filters);
            this.$emit("filtersUpdated");
        },
        clear() {
            if (this.selectedFilters.length > 0) {
                this.collapsed = false;
                this.submitted = false;
                this.removeFilters();
                this.$emit("filtersUpdated");
            }
        },
    },
    watch: {
        showFilters: function(show) {
            this.collapsed = show;
        },
        collapsed: function(collapsed) {
            $("#collapse-filters").collapse(collapsed ? "show" : "hide");
        },
    },
};
</script>

<style scoped></style>
