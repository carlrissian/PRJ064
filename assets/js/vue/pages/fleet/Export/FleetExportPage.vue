<template>
    <fragment>
        <notifications position="top right"></notifications>

        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title" v-text="translations.titles.header"></h3>
                    <!-- <h1 class="mb-0" v-text="translations.titles.header"></h1> -->
                </div>
            </div>

            <div class="kt-portlet__body">
                <div class="kt-align-right">
                    <button
                        @click="downloadExcelFleet()"
                        class="btn btn-primary"
                        v-text="translations.form.export"
                        :disabled="exportInProgress"
                    ></button>
                </div>

                <fleet-export-filter ref="filters" />
            </div>

            <!-- <div class="kt-portlet__foot"></div> -->
        </div>

        <alert v-if="exportResponse !== null" :type="exportResponse.type" class="mt-5" :closable="false">
            <template #text>
                <p v-text="exportResponse.msg" style="margin: 0"></p>
            </template>
        </alert>
    </fragment>
</template>

<script>
import Loading from "../../../../../assets/js/utilities.js";
import Alert from "../../../../../SharedAssets/vue/components/Alert.vue";
import FleetExportFilter from "../../../components/fleet/FleetExportFilter.vue";

export default {
    name: "FleetExportPage",
    components: {
        Alert,
        FleetExportFilter,
    },
    data() {
        return {
            translations,
            exportInProgress: false,
            exportResponse: null,
        };
    },
    methods: {
        downloadExcelFleet: async function() {
            Loading.starLoading();
            this.exportInProgress = true;
            this.exportResponse = null;

            await this.$refs.filters.$refs.erpFilterExport.search();
            const query = this.$store.getters["erpFilter/convertToQuery"];

            await this.axios({
                method: "post",
                url: this.routing.generate("api.fleet.export") + query,
                responseType: "blob",
            })
                .then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data], { type: "application/vnd.ms-excel" }));
                    const link = document.createElement("a");
                    link.href = url;
                    const now = new Date();
                    const formattedDate = `${now.getFullYear()}-${(now.getMonth() + 1).toString().padStart(2, "0")}-${now
                        .getDate()
                        .toString()
                        .padStart(2, "0")}_${now
                        .getHours()
                        .toString()
                        .padStart(2, "0")}-${now
                        .getMinutes()
                        .toString()
                        .padStart(2, "0")}`;
                    const filename =
                        response?.headers["content-disposition"]?.split("filename=")[1] ?? `FleetExport_${formattedDate}.xlsx`;
                    link.setAttribute("download", filename);
                    document.body.appendChild(link);
                    link.click();
                    this.exportResponse = {
                        type: "success",
                        msg: this.translations.form.fleetExportedSuccessNotification,
                    };
                })
                .catch((error) => {
                    console.log(error.response);
                    this.exportResponse = {
                        type: "danger",
                        msg: this.translations.form.errorOnRequest,
                    };
                    // this.$notify({
                    //     type: "error",
                    //     text: this.translations.form.errorOnRequest,
                    //     duration: 5000,
                    // });
                });

            Loading.endLoading();
            this.exportInProgress = false;
        },
    },
};
</script>

<style scoped></style>
