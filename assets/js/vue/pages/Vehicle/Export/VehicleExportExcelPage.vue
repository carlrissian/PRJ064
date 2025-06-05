<template>
  <fragment>
    <h1>{{ translations.header }}</h1>
    <div class="mb-3">
      <hr>
      <button @click="openModalExportToExcel()" class="btn btn-primary">{{ translations.exportButton }}</button>
      <modal-export-excel-confirmation modal-id="modalExportExcelConfirmation"/>
    </div>
  </fragment>
</template>

<script>

import ErpForm from "../../../components/form/ErpForm.vue";
import ModalExportExcelConfirmation from "./ModalExportExcelConfirmation.vue";


export default {
  name: "VehicleExportExcelPage",
  components: {
    ErpForm,
    ModalExportExcelConfirmation,
  },
  props: {},
  data() {
    return {
      translations: {},
      items: [],
    }
  },
  mounted() {
    this.translations = translations;
  },
  methods: {
    async openModalExportToExcel(props) {
      $('#modal-export-excel-confirmation').modal('show');
    }
  }
}
</script>

<style scoped>

</style>