<template>
  <div>
    <vue-bootstrap-table
      v-if="values"
      :values="values"
      :columns="columns"
      :show-filter="false"
      :show-column-picker="false"
      :sortable="true"
      :selectable="selectable"
      :multi-column-sortable=true
      :filter-case-sensitive=false
      :row-click-handler=handleRowFunction
    >
      <template v-slot:name="slotProps">
        {{ slotProps.value.name }}
      </template>
      <template v-slot:description="slotProps">
        {{ slotProps.value.description }}
      </template>
    </vue-bootstrap-table>

    <div class="row">
      <div class="col">
        Mostrando desde {{ offset }} hasta {{ Math.min(totalRows, currentPage * perPage) }} - En total {{ totalRows }} resultados.
        <b-form-select style="width: 55px" v-model="perPage" size="sm" :options="[5,10,15,30,50]"></b-form-select>
        resultados por página.
      </div>
      <div class="col">
        <b-pagination
          align="right"
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          aria-controls="my-table"
        ></b-pagination>
      </div>
    </div>


  </div>
</template>

<script>

import VueBootstrapTable from 'vue2-bootstrap-table2'

export default {
  name: 'ErpAjaxTable',
  components: {
    VueBootstrapTable: VueBootstrapTable,
  },
  props: {
    columns: Array,
    filters: { type: Object },
    paginated: { type: Boolean, default: false },
    async: { type: Boolean, default: false },
    perPage: { type: Number, required: false, default: 10 },
    selectable: { type: Boolean, default: false },
    url: String,
  },
  created () {
    this.fetchItems(this.filters)
    /*EventBus.$on('filtersUpdated', ()=>{
      this.fetchItems(this.$store.getters["filters/getFilters"])
    })*/
  },
  computed: {
    offset () {
      return this.currentPage * this.perPage - this.perPage + 1
    }
  },
  data () {
    return {
      values: [],
      totalRows: 0,
      currentPage: 1,
      tableLoading: false,
    }
  },
  watch: {
    filters: function (filters) {
      this.fetchItems(filters)
    },
    offset: function () {
      this.fetchItems(this.$store.state.filters.filters)
    },
    perPage: function () {
      this.fetchItems(this.$store.state.filters.filters)
    },
  },
  methods: {
    handleRowFunction (event, row) {
      console.info({ row })
    },
    async fetchItems (filters) {
      this.tableLoading = true
      let params = { offset: this.offset, limit: this.perPage, ...filters }
      let { data } = await this.$axios.get(this.url, { params: params })
      if (data) {
        this.values = data.collection
        this.totalRows = data.total
        this.$store.commit('filters/items', this.values)
        this.$store.commit('filters/count', this.totalRows)
      }
      this.tableLoading = false
    },
  }
}
</script>

<style scoped>

</style>
