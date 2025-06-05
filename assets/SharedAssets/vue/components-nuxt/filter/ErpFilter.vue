<template>
    <fragment>
        <div class="row mb-5">
            <!-- Open/close button + delete filters -->
            <div class="col-6">
                <b-button @click="collapsed = !collapsed" id="show-filters" class="filter-button" variant="primary">
                    {{ $t("filters") }}&nbsp;&nbsp;&nbsp;<b-icon :icon="collapsed ? 'chevron-up' : 'chevron-down'"></b-icon>
                </b-button>

                <b-button
                    v-show="!collapsed && selectedFilters.length > 0"
                    @click="clear"
                    class="filter-button"
                    variant="primary"
                    v-text="$t('deleteFilters')"
                >
                </b-button>
            </div>
            <!--  -->
            <div class="col-6 d-flex flex-row-reverse">
                <slot name="actions"></slot>
            </div>

            <!-- Chips -->
            <div v-if="!collapsed && selectedFilters.length > 0" id="filter-chips" class="col-12 d-inline">
                <b-button
                    v-for="(item, index) in selectedFilters"
                    :key="index"
                    @click="removeItemFilter(item)"
                    class="mr-1 mb-2"
                    variant="dark"
                    pill
                >
                    {{ formatterChip(item) }}
                    <b-icon variant="light" class="ml-2" icon="x-circle-fill"></b-icon>
                </b-button>
            </div>
            <!--  -->

            <!-- Collapse dropdown -->
            <b-collapse id="collapse-filters" class="col-12" v-model="collapsed" visible>
                <form @submit.prevent="search">
                    <b-card class="card-filters">
                        <template #header>
                            <b-row align-h="start">
                                <i class="mr-2 fa fa-filter" style="color: black; align-self: center"></i>
                                <h4 style="margin: 0" v-text="$t('filterList')"></h4>
                            </b-row>
                        </template>

                        <b-card-text>
                            <div class="row">
                                <!--    
                                    INFO: estrucutra de campos de filtro
                                    - ref: siempre debe ir relleno, es esencial para el funcionamiento del componente. Preferiblemente que sea la misma key que el valor de traducción.
                                    - name: es el nombre del campo que se enviará al backend.
                                    - id: se puede introducir según lo deseado, no afecta al funcionamiento.
                                    - div-class: es la clase que se le aplicará al div que contiene el campo.
                                    - label: es el texto que se mostrará en el label del campo.
                                    - placeholder: es el texto que se mostrará en el campo cuando esté vacío. Si no se introduce, se mostrará el valor de label.
                                    
                                    WARN: en el caso de los campos de rango fecha, tanto la propiedad ref como name deben de ser iguales. 
                                -->
                                <slot name="filter-formfields"></slot>
                            </div>
                        </b-card-text>

                        <template #footer>
                            <b-row align-h="end">
                                <b-button @click="clear" class="mr-3" variant="outline-primary" v-text="$t('deleteFilters')">
                                </b-button>
                                <b-button type="submit" variant="primary" v-text="$t('search')"></b-button>
                            </b-row>
                        </template>
                    </b-card>
                </form>
            </b-collapse>
            <!--  -->
        </div>
    </fragment>
</template>

<script>
import Vue from "vue";
import { DATE_FROM, DATE_TO } from "./form/ErpDateRangeFilter.vue";
import { TIME_FROM, TIME_TO } from "./form/ErpTimeRangeFilter.vue";

export default {
    name: "ErpFilter",
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
        autoSubmit: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            DATE_FROM,
            DATE_TO,
            TIME_FROM,
            TIME_TO,
            collapsed: this.showFilters,
            submitted: false,
            selectedFilters: [],
            formFields: [],
            filters: {},
        };
    },
    mounted() {
        /**
         * INFO Recogemos todas las referencias de los campos introducidos en el slot:
         * Accediendo al context, realmente estamos accediendo al componente donde se ha declarado ErpFilter y el slot.
         * En este caso, el componente que contiene ErpFilter y su slot SÓLO debería de incluir los campos del filtro.
         * Si añadimos más campos en el componente que estén fuera del slot, se recogerán.
         * Este componente no está preparado para leer elementos que no sean VueComponent.
         *
         * FIXME revisar si es posible recoger los campos de otra manera.
         */
        this.formFields = this.$slots["filter-formfields"][0]?.context?.$refs;
    },
    beforeDestroy() {
        this.$store.dispatch(`${this.storeModuleName}/removeFilters`);
    },
    methods: {
        formatterChip(item) {
            if (item.type === "daterange") {
                if (!["", null, undefined].includes(item.text)) {
                    return `${this.$t(item.name)}: ${item.text}`;
                } else {
                    if (!["", null, undefined].includes(item.value[String(DATE_FROM).toLowerCase()])) {
                        return `${this.$t(item.name)} ${this.$t(String(DATE_FROM).toLowerCase())}: ${
                            item.value[String(DATE_FROM).toLowerCase()]
                        }`;
                    }
                    if (!["", null, undefined].includes(item.value[String(DATE_TO).toLowerCase()])) {
                        return `${this.$t(item.name)} ${this.$t(String(DATE_TO).toLowerCase())}: ${
                            item.value[String(DATE_TO).toLowerCase()]
                        }`;
                    }
                }
            }
            if (item.type === "timerange") {
                if (!["", null, undefined].includes(item.text)) {
                    return `${this.$t(item.name)}: ${item.text}`;
                } else {
                    if (!["", null, undefined].includes(item.value[String(TIME_FROM).toLowerCase()])) {
                        return `${this.$t(item.name)} ${this.$t(String(TIME_FROM).toLowerCase())}: ${
                            item.value[String(TIME_FROM).toLowerCase()]
                        }`;
                    }
                    if (!["", null, undefined].includes(item.value[String(TIME_TO).toLowerCase()])) {
                        return `${this.$t(item.name)} ${this.$t(String(TIME_TO).toLowerCase())}: ${
                            item.value[String(TIME_TO).toLowerCase()]
                        }`;
                    }
                }
            }

            if (item.type === "select") {
                return Array.isArray(item.value)
                    ? `${this.$t(item.name)}: ${item.text.join(", ")}`
                    : `${this.$t(item.name)}: ${item.text}`;
            }

            if (item.value instanceof Object) {
                return `${this.$t(item.name)}: ${item?.value["name"]}`;
            }

            if (typeof item.value === "boolean") {
                return `${this.$t(item.name)}: ${item.value ? this.$t("yes") : this.$t("no")}`;
            }

            return `${this.$t(item.name)}: ${item.value}`;
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
                if (field.type === "daterange") {
                    if (Object.values(field.value).every((value) => !["", null, undefined].includes(value))) {
                        this.selectedFilters.push(field);
                        this.filters[`${field.name}${DATE_FROM}`] = field.value[String(DATE_FROM).toLowerCase()];
                        this.filters[`${field.name}${DATE_TO}`] = field.value[String(DATE_TO).toLowerCase()];
                    } else {
                        if (!["", null, undefined].includes(field.value[String(DATE_FROM).toLowerCase()])) {
                            this.selectedFilters.push(field);
                            this.filters[`${field.name}${DATE_FROM}`] = field.value[String(DATE_FROM).toLowerCase()];
                        }
                        if (!["", null, undefined].includes(field.value[String(DATE_TO).toLowerCase()])) {
                            this.selectedFilters.push(field);
                            this.filters[`${field.name}${DATE_TO}`] = field.value[String(DATE_TO).toLowerCase()];
                        }
                    }
                }
                if (field.type === "timerange") {
                    if (Object.values(field.value).every((value) => !["", null, undefined].includes(value))) {
                        this.selectedFilters.push(field);
                        this.filters[`${field.name}${TIME_FROM}`] = field.value[String(TIME_FROM).toLowerCase()];
                        this.filters[`${field.name}${TIME_TO}`] = field.value[String(TIME_TO).toLowerCase()];
                    } else {
                        if (!["", null, undefined].includes(field.value[String(TIME_FROM).toLowerCase()])) {
                            this.selectedFilters.push(field);
                            this.filters[`${field.name}${TIME_FROM}`] = field.value[String(TIME_FROM).toLowerCase()];
                        }
                        if (!["", null, undefined].includes(field.value[String(TIME_TO).toLowerCase()])) {
                            this.selectedFilters.push(field);
                            this.filters[`${field.name}${TIME_TO}`] = field.value[String(TIME_TO).toLowerCase()];
                        }
                    }
                }

                if (!field.manualSave) {
                    this.filters[field.filterName] = field.value;
                    this.selectedFilters.push(field);
                }
            }
        },
        saveFilters() {
            this.flush();

            Object.values(this.formFields).forEach((element) => {
                let field = {
                    type: null,
                    filterName: null,
                    name: null,
                    value: null,
                    text: null,
                    manualSave: false,
                };

                if (element instanceof Vue) {
                    field.name = element.$vnode.data.ref;
                    field.filterName = element.name;

                    switch (element.$vnode.componentOptions?.Ctor?.options?.name) {
                        case "ErpInputFilter":
                        case "ErpInputNumberFilter":
                            field.value = element.data;
                            break;
                        case "ErpCheckBoxFilter":
                            field.value = element.useValues
                                ? element.isChecked
                                    ? element.checkedValue
                                    : element.uncheckedValue
                                : element.isChecked;
                            break;
                        case "ErpSingleSelectFilter":
                            field.type = "select";
                            field.value = element.selection;
                            let selectedOption =
                                element.$refs.select.$refs.input.options[element.$refs.select.$refs.input.selectedIndex];
                            field.text = selectedOption?.text;
                            break;
                        case "ErpMultiSelectFilter":
                            field.type = "select";
                            let selectedOptions = element.selection;
                            if (selectedOptions?.length > 0) {
                                field.value = [];
                                field.text = [];
                                selectedOptions.forEach((item) => {
                                    field.value.push(item.value);
                                    field.text.push(item.text);
                                });
                            }
                            break;
                        case "ErpDatePickerFilter":
                            field.value = element.$refs.datepicker.$refs.control.formattedValue;
                            break;
                        case "ErpTimePickerFilter":
                            field.value = element.$refs.timepicker.$refs.control.formattedValue;
                            break;
                        case "ErpDateRangeFilter":
                            field.type = "daterange";
                            field.manualSave = true;
                            field.value = {
                                [String(DATE_FROM).toLowerCase()]: element.$refs[`datepicker${DATE_FROM}`].$refs.control.value
                                    ? element.$refs[`datepicker${DATE_FROM}`].$refs.control.formattedValue
                                    : null,
                                [String(DATE_TO).toLowerCase()]: element.$refs[`datepicker${DATE_TO}`].$refs.control.value
                                    ? element.$refs[`datepicker${DATE_TO}`].$refs.control.formattedValue
                                    : null,
                            };

                            if (Object.values(field.value).every((value) => !["", null, undefined].includes(value))) {
                                field.text = `${field.value[String(DATE_FROM).toLowerCase()]} - ${
                                    field.value[String(DATE_TO).toLowerCase()]
                                }`;
                            }
                            break;
                        case "ErpTimeRangeFilter":
                            field.type = "timerange";
                            field.manualSave = true;
                            field.value = {
                                [String(TIME_FROM).toLowerCase()]: element.$refs[`timepicker${TIME_FROM}`].$refs.control.value
                                    ? element.$refs[`timepicker${TIME_FROM}`].$refs.control.formattedValue
                                    : null,
                                [String(TIME_TO).toLowerCase()]: element.$refs[`timepicker${TIME_TO}`].$refs.control.value
                                    ? element.$refs[`timepicker${TIME_TO}`].$refs.control.formattedValue
                                    : null,
                            };

                            if (Object.values(field.value).every((value) => !["", null, undefined].includes(value))) {
                                field.text = `${field.value[String(TIME_FROM).toLowerCase()]} - ${
                                    field.value[String(TIME_TO).toLowerCase()]
                                }`;
                            }
                            break;
                        default:
                            console.warn("Tipo de elemento desconocido: ", element);
                            break;
                    }

                    this.saveField(field);
                }
            });
        },
        removeItemFilter(item) {
            this.flush(item);

            Object.values(this.formFields).forEach((element) => {
                if (element instanceof Vue && item.name === element?.$vnode.data.ref) {
                    switch (element.$vnode.componentOptions?.Ctor?.options?.name) {
                        case "ErpInputFilter":
                        case "ErpInputNumberFilter":
                            element.data = null;
                            break;
                        case "ErpCheckBoxFilter":
                            element.isChecked = null;
                            break;
                        case "ErpSingleSelectFilter":
                        case "ErpMultiSelectFilter":
                            element.selection = null;
                            break;
                        case "ErpDatePickerFilter":
                            element.date = null;
                            break;
                        case "ErpTimePickerFilter":
                            element.time = null;
                            break;
                        case "ErpDateRangeFilter":
                            if (!["", null, undefined].includes(item.value[String(DATE_FROM).toLowerCase()])) {
                                element.dates.from = null;
                            }
                            if (!["", null, undefined].includes(item.value[String(DATE_TO).toLowerCase()])) {
                                element.dates.to = null;
                            }
                            break;
                        case "ErpTimeRangeFilter":
                            if (!["", null, undefined].includes(item.value[String(TIME_FROM).toLowerCase()])) {
                                element.times.from = null;
                            }
                            if (!["", null, undefined].includes(item.value[String(TIME_TO).toLowerCase()])) {
                                element.times.to = null;
                            }
                            break;
                        default:
                            console.warn("Tipo de elemento desconocido: ", element);
                            break;
                    }

                    this.$emit("filterDeleted", item.name);
                }
            });

            if (this.selectedFilters.length > 0 || this.autoSubmit) {
                // Es necesario para que a los componentes de Bootsrap les de tiempo a actualizar el value
                this.$nextTick(function () {
                    this.search();
                });
            } else {
                this.submitted = false;
                this.$emit("filtersCleared", this.submitted);
            }
        },
        removeFilters() {
            this.flush();

            Object.values(this.formFields).forEach((element) => {
                if (element instanceof Vue) {
                    switch (element.$vnode.componentOptions?.Ctor?.options?.name) {
                        case "ErpInputFilter":
                        case "ErpInputNumberFilter":
                            element.data = null;
                            break;
                        case "ErpCheckBoxFilter":
                            element.isChecked = null;
                            break;
                        case "ErpSingleSelectFilter":
                        case "ErpMultiSelectFilter":
                            element.selection = null;
                            break;
                        case "ErpDatePickerFilter":
                            element.date = null;
                            break;
                        case "ErpTimePickerFilter":
                            element.time = null;
                            break;
                        case "ErpDateRangeFilter":
                            element.dates.from = null;
                            element.dates.to = null;
                            break;
                        case "ErpTimeRangeFilter":
                            element.times.from = null;
                            element.times.to = null;
                            break;
                        default:
                            console.warn("Tipo de elemento desconocido: ", element);
                            break;
                    }
                }
            });

            this.$emit("filtersCleared", this.submitted);

            if (this.autoSubmit) {
                // Es necesario para que a los componentes de Bootsrap les de tiempo a actualizar el value
                this.$nextTick(function () {
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
            }
            this.removeFilters();
            this.$emit("filtersUpdated");
        },
    },
    watch: {
        showFilters: function (show) {
            this.collapsed = show;
        },
    },
};
</script>

<style scoped></style>
