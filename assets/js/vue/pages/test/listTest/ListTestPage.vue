<template>
  <fragment>
    <list-test-filter/>
    <div class="kt-portlet kt-portlet--bordered">
      <div class="kt-portlet__body">
        <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded">
          <erp-ajax-table :url="routing.generate('api.test.filter')" :columns="columns" :options="options"  />
        </div>
      </div>
    </div>
  </fragment>
</template>

<script>
import ErpAjaxTable from "../../../components/table/ErpAjaxTable";
import ListTestFilter from "./ListTestFilter";
export default {
    name: "ListTestPage",
    components: {ListTestFilter, ErpAjaxTable},
    data () {
      return {
        columns: [
          { field: 'code', title: translationsTestList.code, sortable: true, formatter: this.formatter },
          { field: 'name', title: translationsTestList.name, sortable: true, formatter: this.formatter },
          { field: 'notes', title: translationsTestList.notes, sortable: true, formatter: this.formatter},
          {
            title: translationsTestList.options,
            formatter: this.actionsFormatter,
            events: {
              'click .edit': (e, value, row) =>  this.clickEditRow(row),
              'click .show': (e, value, row) =>  this.clickEditShow(row)
            },
            width: 160
          }
        ],
        options: {
          pagination: true,
          locale: 'es-ES',
          scrollX: true
        },
        row: {},
      }
    },
    methods: {
      formatter(value) {
        if(value === null){return "-"}
        return value;
      },
      actionsFormatter(value, row) {
        const actions = [
          '<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md edit" title="'+translationsTestList.edit+'"><i class="flaticon-edit"></i></a>',
          '<a href="javascript:void(0)" class="btn btn-sm btn-clean btn-icon btn-icon-md show" title="'+translationsTestList.show+'"><i class="flaticon-eye"></i></a>',
        ];
        return actions.join('');
      },
      clickEditShow(row) {
        location.href = this.routing.generate('view.test.show', { id: row.id });
      },
      clickEditRow(row) {
        location.href = this.routing.generate('view.test.edit', { id: row.id });
      }
    }
  }
</script>

<style scoped>

</style>