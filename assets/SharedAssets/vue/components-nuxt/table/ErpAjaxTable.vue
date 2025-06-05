<template>
    <fragment>
        <b-card>
            <!-- BootstrapVue Table Doc oficial: https://bootstrap-vue.org/docs/components/table -->
            <b-table
                responsive
                outlined
                hover
                :id="id"
                :ref="reference"
                :fields="columns"
                :items="items"
                :busy="isLoading"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortOrder"
                :no-local-sorting="!localFilter"
                sort-icon-left
                :selectable="enableSelections"
                :select-mode="selectionMode"
                @row-selected="$emit('row-selected', $event)"
                @row-clicked="
                    $emit('row-clicked', $event);
                    updateSelectAll();
                "
                show-empty
            >
                <!-- Customizble columnas -->
                <template v-for="col in columns" #[`cell(${col.key})`]="data">
                    <slot v-if="col.custom" :name="`cell-${col.key}`" :data="data"></slot>
                    <div v-else v-text="data.value"></div>
                </template>
                <!--  -->

                <!-- Checkbox in thead -->
                <template v-if="enableSelections && ['multi', 'range'].includes(selectionMode)" #head(checkbox)="data">
                    <b-form-checkbox
                        v-model="selectAll"
                        @change="
                            selectAllRows($event);
                            $emit('checkbox-clicked', $event);
                        "
                    ></b-form-checkbox>
                </template>
                <!--  -->
                <!-- Checkboxes per row -->
                <template v-if="enableSelections" #cell(checkbox)="data">
                    <b-form-checkbox
                        v-model="data.rowSelected"
                        @change="
                            selectRow($event, data.index);
                            updateSelectAll();
                            $emit('checkbox-clicked', $event, data.index);
                        "
                    ></b-form-checkbox>
                    <!-- Con esto haces la misma lógica que en el row-clicked de arriba. Pasando data tienes los datos de la fila -->
                    <!-- $emit('row-clicked', data); -->
                </template>
                <!--  -->

                <!-- Action buttons template -->
                <template #cell(actions)="data">
                    <div class="actions">
                        <slot name="action-buttons" :row="data"></slot>
                    </div>
                </template>
                <!--  -->

                <!-- Loading -->
                <template #table-busy>
                    <div class="text-center text-danger my-2">
                        <b-spinner class="align-middle"></b-spinner>
                        <strong v-text="`${$t('loading')}...`"></strong>
                    </div>
                </template>
                <!--  -->

                <!-- Empty items -->
                <template #empty="scope">
                    <div class="text-center my-2" v-text="$t('noMatchingRecordsFound')"></div>
                </template>
                <template #emptyfiltered="scope">
                    <div class="text-center my-2" v-text="$t('noMatchingRecordsFound')"></div>
                </template>
                <!--  -->
            </b-table>

            <!-- Pagination -->
            <div v-show="items.length > 0" class="row m-2">
                <div :class="pagination ? 'col-6' : 'col-12'">
                    {{
                        $t("showingElementsInTable", {
                            offset: offset + 1,
                            limit: pagination ? Math.min(totalRows, currentPage * limit) : totalRows,
                            total: totalRows,
                        })
                    }}
                    <span v-if="enableLimit">
                        <b-form-select
                            style="width: 60px"
                            v-model="limit"
                            size="sm"
                            :options="paginationLimitOptions"
                        ></b-form-select>
                        {{ $t("resultsPerPage") }}
                    </span>
                </div>
                <div v-if="pagination" class="col-6 pagination">
                    <b-pagination
                        v-model="currentPage"
                        :aria-controls="id"
                        :total-rows="totalRows"
                        :per-page="limit"
                        last-number
                    ></b-pagination>
                </div>
            </div>
            <!--  -->
        </b-card>
    </fragment>
</template>

<script>
export default {
    name: "ErpAjaxTable",
    components: {},
    props: {
        id: {
            type: String,
            default: "b-table",
        },
        reference: {
            type: String,
            default: "erpAjaxTable",
        },
        url: {
            type: String,
            required: true,
        },
        storeModuleName: {
            type: String,
            default: "erpFilter",
        },
        columns: {
            type: Array,
            required: true,
        },
        defaultParameters: {
            type: Object,
            default: function () {
                return {};
            },
        },
        pagination: {
            type: Boolean,
            default: true,
        },
        paginationLimitOptions: {
            type: Array,
            default: [5, 10, 25, 50],
        },
        enableLimit: {
            type: Boolean,
            default: true,
        },
        enableSelections: {
            type: Boolean,
            default: false,
        },
        enableCheckboxSelections: {
            type: Boolean,
            default: false,
        },
        selectionMode: {
            type: String,
            validator: function (value) {
                return ["single", "multi", "range"].includes(value);
            },
            default: "single",
        },
        stickyHeader: {
            type: Boolean,
            default: false,
        },
        // Activar si se quiere insertar items a la tabla manualmente
        manualItems: {
            type: Boolean,
            default: false,
        },
        localFilter: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            items: [],
            currentPage: 1,
            limit:
                Array.isArray(this.paginationLimitOptions) && this.paginationLimitOptions.length > 1
                    ? JSON.stringify(this.paginationLimitOptions) === JSON.stringify([5, 10, 25, 50])
                        ? this.paginationLimitOptions[1]
                        : this.paginationLimitOptions[0]
                    : 10,
            totalRows: 0,
            sortBy: null,
            sortOrder: false,
            isLoading: false,
            selectAll: false,
        };
    },
    created() {
        this.$nextTick(function () {
            this.fetchItems(this.filters);
        });
    },
    computed: {
        /**
         * INFO: declarando esta variable en computed conseguimos que atienda a mutaciones/cambios en el store
         *  y, posteriormente, el watch se encarga de llamar a fetchItems con los nuevos filtros.
         */
        filters() {
            return this.$store.state[this.storeModuleName].filters;
        },
        offset() {
            return this.currentPage * this.limit - this.limit;
        },
    },
    watch: {
        filters: function (filters) {
            this.fetchItems(filters);
        },
        offset: function () {
            this.fetchItems(this.filters);
        },
        limit: function () {
            this.fetchItems(this.filters);
        },
        sortBy: function () {
            this.fetchItems(this.filters);
        },
        sortOrder: function () {
            this.fetchItems(this.filters);
        },
    },
    methods: {
        selectRow(checked, index) {
            checked ? this.$refs[this.reference].selectRow(index) : this.$refs[this.reference].unselectRow(index);
        },
        selectAllRows(checked) {
            this.selectAll = checked;
            this.selectAll ? this.$refs[this.reference].selectAllRows() : this.$refs[this.reference].clearSelected();
        },
        updateSelectAll() {
            this.selectAll = this.items.every((item, index) => this.$refs[this.reference].isRowSelected(index));
        },
        async fetchItems(filters) {
            if (!this.manualItems && !this.localFilter) {
                this.items.length = 0;
                this.isLoading = true;

                let params = {
                    sort: this.sortBy,
                    order: this.sortOrder ? "desc" : "asc",
                    ...this.defaultParameters,
                    ...filters,
                };
                if (this.pagination) params.offset = this.offset;
                if (this.enableLimit) params.limit = this.limit;

                await this.$axios
                    .get(this.url, { params: params })
                    .then((response) => {
                        if (response.data) {
                            this.items = response.data.rows;
                            this.totalRows = response.data.total;
                            this.$store.commit(this.storeModuleName + "/items", this.items);
                            this.$store.commit(this.storeModuleName + "/count", this.totalRows);

                            // If enbaleLimit = false then limit = totalRows
                            if (!this.enableLimit) {
                                this.limit = this.totalRows;
                            }
                        }

                        this.isLoading = false;
                    })
                    .catch((e) => {
                        console.error(e);
                        this.isLoading = false;
                    });
            }

            if (this.localFilter) this.$emit("onLocalFiltering", filters);
        },
        manualFetchItems(data) {
            this.isLoading = true;

            this.items = data?.rows;
            this.totalRows = data?.total;
            this.$store.commit(this.storeModuleName + "/items", this.items);
            this.$store.commit(this.storeModuleName + "/count", this.totalRows);

            // If enbaleLimit = false then limit = totalRows
            if (!this.enableLimit) {
                this.limit = this.totalRows;
            }

            this.isLoading = false;
        },
        refresh() {
            this.fetchItems(this.filters);
        },
    },
};
</script>

<style scoped>
td {
    display: flex !important;
    justify-content: center !important;
}
div.actions {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0;
}

div.row > div.pagination {
    display: flex;
    justify-content: flex-end;
}
</style>
