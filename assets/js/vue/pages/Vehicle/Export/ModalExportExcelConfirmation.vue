<template>
    <erp-modal title="Export Excel" modal-id="modal-export-excel-confirmation">
        <template slot="body">
            <p>Are you sure do you want to export database information to excel?</p>
        </template>
        <template slot="footer">
            <div id="div_boton_centrado" class="kt-align-right">
                <button @click="accept" type="submit" style="" id="btn-create-modal" class="btn btn-dark kt-label-bg-color-4">Accept</button>
                <button @click="cancel" type="submit" style="" id="btn-cancel-modal" class="btn btn-dark kt-label-bg-color-4">Cancel</button>
            </div>
        </template>
    </erp-modal>
</template>

<script>
import ErpModal from "../../../components/modal/ErpModal.vue";
import Axios from "axios";
import Loading from "../../../../../assets/js/utilities"

export default {
    name: "ModalExportExcelConfirmation",
    components: {
        ErpModal
    },
    props:{
       row: {}
    },
    methods: {
        async accept(e) {
          Loading.starLoading();
            Axios.post(this.routing.generate('api.vehicle.export'), {
            },{responseType: 'blob'}

            ).then(function (result) {

              Loading.endLoading()
                let date = new Date();
                let day = date.getDate();
                day = day <= 9 ? "0"+day : day;
                let month = date.getMonth()+1;
                month = month <= 9 ? "0"+month : month;
                let year = date.getFullYear();

                let blob = new Blob([result.data], { type: 'application/vnd.ms-excel' });

                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "Vehicles_"+day+"-"+month+"-"+year+".xlsx";
                link.click();

            }).catch(
                function (error) {

                }
            );
            $('#modal-export-excel-confirmation').modal('hide');
        },
        async cancel(e) {
            $('#modal-export-excel-confirmation').modal('hide');
        }

    },
}
</script>

<style scoped>

</style>