<template>
    <fragment>
        <notifications position="top right"></notifications>

        <div class="kt-portlet kt-portlet--bordered">
            <div class="kt-portlet__body">
                <div class="kt-portlet kt-portlet--bordered">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title" v-text="translations.titles.header"></h3>
                        </div>
                    </div>

                    <div class="kt-portlet__body">
                        <input-file-pond
                            @addedFile="getFile"
                            @removedFile="removeFile"
                            ref="inputFilePond"
                            name="uploadExcel"
                            id="uploadExcel"
                            :accepted-files="[
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                '.xlsx',
                            ]"
                            max-files="1"
                            div-class="col-12"
                        />
                    </div>

                    <div class="kt-portlet__foot">
                        <div
                            class="d-flex"
                            :class="{
                                'justify-content-between': showMessagesButtons,
                                'justify-content-end': !showMessagesButtons,
                            }"
                        >
                            <div v-show="showMessagesButtons" class="">
                                <button
                                    @click="(showMessages = !showMessages), (showimportResponse = !showMessages)"
                                    type="button"
                                    class="btn btn-dark kt-label-bg-color-4"
                                >
                                    <i class="la" :class="{ 'la-angle-up': showMessages, 'la-angle-down': !showMessages }"></i>
                                    {{ translations.form.showMessages }}
                                </button>
                                <button
                                    @click="exportErrors"
                                    type="button"
                                    class="btn btn-icon btn-dark kt-label-bg-color-4"
                                    :title="translations.form.downloadMessages"
                                >
                                    <i class="la la-download"></i>
                                </button>
                            </div>
                            <button
                                @click="uploadExcelFile"
                                type="submit"
                                class="btn btn-dark kt-label-bg-color-4"
                                :disabled="!enableUploadButton || importInProgress"
                            >
                                <i class="la la-upload"></i>
                                {{ translations.form.import }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <alert v-if="importResponse !== null && showimportResponse" :type="importResponse.type" class="mt-5" :closable="false">
            <template #text>
                <p v-text="importResponse.msg" style="margin: 0"></p>
            </template>
        </alert>

        <div v-if="showMessages">
            <alert v-if="successVehiclesList !== null" type="success" class="mt-5" :closable="false">
                <template #text>
                    <p v-html="successVehiclesList" style="margin: 0"></p>
                </template>
            </alert>

            <alert v-if="errorVehiclesList !== null" type="danger" class="mt-5" :closable="false">
                <template #text>
                    <p v-html="errorVehiclesList" style="margin: 0"></p>
                </template>
            </alert>
        </div>
    </fragment>
</template>

<script>
import Loading from "../../../../../assets/js/utilities";
import Alert from "../../../../../SharedAssets/vue/components/Alert.vue";
import InputFilePond from "../../../../../SharedAssets/vue/components/base/inputs/InputFilePond.vue";
import { htmlToText } from "html-to-text";

export default {
    name: "FleetImportPage",
    components: {
        Alert,
        InputFilePond,
    },
    data() {
        return {
            translations,
            file: null,
            importInProgress: false,
            importResponse: null,
            showimportResponse: false,
            showMessages: false,
            successVehiclesList: null,
            errorVehiclesList: null,
        };
    },
    computed: {
        enableUploadButton() {
            return this.file !== null;
        },
        showMessagesButtons() {
            return this.successVehiclesList !== null || this.errorVehiclesList !== null;
        },
    },
    methods: {
        getFile(file) {
            this.file = file;
        },
        removeFile() {
            this.file = null;
        },
        flush() {
            this.showimportResponse = false;
            this.showMessages = false;
            this.successVehiclesList = null;
            this.errorVehiclesList = null;
        },
        uploadExcelFile: async function() {
            Loading.starLoading();
            this.flush();
            this.importInProgress = true;
            this.importResponse = null;

            let url = this.routing.generate("api.fleet.import");
            let formData = new FormData();
            formData.append("file", this.file.file);

            let result = await this.axios
                .post(url, formData)
                .then((response) => {
                    this.importResponse = {
                        type: "success",
                        msg: this.translations.form.importFleetSuccessNotification,
                    };
                    return response.data;
                })
                .catch((error) => {
                    console.error(error.response);
                    this.importResponse = {
                        type: "danger",
                        msg: this.translations.form.errorImportFleetNotification,
                    };
                    this.showMessages = true;
                    return error.response.data;
                });

            this.formatSuccessMessages(result?.vehicles?.imported);
            this.formatErrorMessages(result?.vehicles?.notImported ?? result?.vehicles, result?.sapErrors);
            this.importInProgress = false;
            Loading.endLoading();
        },
        formatSuccessMessages(lines) {
            if (Array.isArray(lines) && lines.length > 0) {
                this.successVehiclesList = `<p>${translations.form.importedVehicles} (${translations.form.excelLines}):</p>`;
                this.successVehiclesList += "<ul>";
                lines.forEach((line) => {
                    this.successVehiclesList += `<li>${translations.form.line} ${line.line}</li>`;
                });
                this.successVehiclesList += "</ul>";
            }
        },
        formatErrorMessages(lines, sapErrors = []) {
            if (Array.isArray(lines) && lines.length > 0) {
                this.errorVehiclesList = this.errorVehiclesList ?? "";
                this.errorVehiclesList += `<p>${translations.form.errorImportFleetNotification}:</p>`;
                this.errorVehiclesList += "<ul>";
                lines.forEach((msg) => {
                    this.errorVehiclesList += `<li>${msg}</li>`;
                });
                this.errorVehiclesList += "</ul>";
            } else if (typeof lines === "object" && Object.keys(lines).length > 0) {
                this.errorVehiclesList = this.errorVehiclesList ?? "";
                this.errorVehiclesList += `<p>${translations.form.notImportedVehicles}:</p>`;
                Object.keys(lines).forEach((line) => {
                    this.errorVehiclesList += `<span>${translations.form.line} ${line}:</span>`;
                    this.errorVehiclesList += "<ul>";
                    lines[line].forEach((msg) => {
                        this.errorVehiclesList += `<li>${msg}</li>`;
                    });
                    this.errorVehiclesList += "</ul>";
                });
            }
            if (Array.isArray(sapErrors) && sapErrors.length > 0) {
                this.errorVehiclesList = this.errorVehiclesList ?? "";
                this.errorVehiclesList += `<p>${translations.form.errorsFromSAP}</p>`;
                this.errorVehiclesList += "<ul>";
                sapErrors.forEach((msg) => {
                    this.errorVehiclesList += `<li>${msg}</li>`;
                });
                this.errorVehiclesList += "</ul>";
            }
        },
        exportErrors() {
            let errors = htmlToText(this.errorVehiclesList);
            let blob = new Blob([errors], { type: "text/plain" });
            let url = window.URL.createObjectURL(blob);
            let a = document.createElement("a");
            a.href = url;
            a.download = "import_fleet_errors.txt";
            a.click();
            window.URL.revokeObjectURL(url);
        },
    },
};
</script>

<style scoped></style>
