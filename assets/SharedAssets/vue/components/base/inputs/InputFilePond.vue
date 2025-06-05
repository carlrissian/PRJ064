<template>
    <div :class="divClass">
        <label v-if="label" :class="labelClass" :for="id" v-text="label"></label>
        <file-pond
            @init="init"
            @warning="warning"
            @error="error"
            @addfilestart="addFileStart"
            @addfileprogress="addFileProgress"
            @addfile="addedFile"
            @processfilestart="processFileStart"
            @processfileprogress="processFileProgress"
            @processfileabort="processFileAbort"
            @processfile="processFileFinished"
            @processfiles="processFilesFinished"
            @removefile="removedFile"
            @updatedfiles="updatedFiles"
            @activatefile="fileClicked"
            :ref="reference"
            :name="name"
            :id="id"
            :label-idle="placeholder"
            :accepted-file-types="Array.isArray(acceptedFiles) ? acceptedFiles.join(', ') : acceptedFiles"
            :allow-multiple="allowMultiple"
            :allowRevert="allowRevert"
            :server="serverData"
            v-bind="$attrs"
        />
    </div>
</template>

<script>
import vueFilePond, { setOptions } from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

export default {
    name: "InputFilePond",
    components: {
        FilePond,
    },
    props: {
        name: String,
        id: String,
        reference: {
            type: String,
            default: "filepond",
        },
        label: String,
        placeholder: {
            type: String,
            default: '<span>Drag & Drop your file or <span class="filepond--label-action">Browse</span>',
        },
        token: String,
        acceptedFiles: [String, Array],
        allowMultiple: {
            type: Boolean,
            default: false,
        },
        allowRevert: {
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
        server: {
            type: String,
            default: null,
        },
        customOptions: {
            type: Object,
            default: null,
        },
        divClass: {
            type: String,
            default: null,
        },
        labelClass: {
            type: String,
            default: "control-label",
        },
    },
    computed: {
        serverData() {
            return this.server
                ? {
                      url: this.server,
                      process: {
                          headers: {
                              "X-CSRF-Token": this.token,
                          },
                          onload: (response) => this.$emit("ajaxOnload", response),
                          onerror: (response) => this.$emit("ajaxError", response),
                      },
                  }
                : undefined;
        },
        // INFO computed no atiende bien a los cambios en FilePond
        // files() {
        //     return this.allowMultiple ? this.$refs[this.reference].getFiles() : this.$refs[this.reference].getFile();
        // },
    },
    mounted() {
        if (this.server) {
            setOptions(
                this.customOptions ?? {
                    labelFileTypeNotAllowed: ["Invalid file type"],
                    labelInvalidField: ["Field contains invalid files"],
                    labelFileWaitingForSize: ["Waiting for file size"],
                    labelFileSizeNotAvailable: ["Size not available"],
                    labelFileCountSingular: ["file in list"],
                    labelFileCountPlural: ["files in list"],
                    labelFileLoading: ["Loading"],
                    labelFileAdded: ["Added"],
                    labelFileLoadError: ["Error during load"],
                    labelFileRemoved: ["Removed"],
                    labelFileRemoveError: ["Error during remove"],
                    labelFileProcessing: ["Uploading"],
                    labelFileProcessingComplete: ["Upload complete"],
                    labelFileProcessingAborted: ["Upload cancelled"],
                    labelFileProcessingError: ["Error during upload"],
                    labelFileProcessingRevertError: ["Error during revert"],
                    labelTapToCancel: ["Tap to cancel"],
                    labelTapToRetry: ["Tap to retry"],
                    labelTapToUndo: ["Tap to undo"],
                    labelButtonRemoveItem: ["Remove"],
                    labelButtonAbortItemLoad: ["Abort"],
                    labelButtonRetryItemLoad: ["Retry"],
                    labelButtonAbortItemProcessing: ["Cancel"],
                    labelButtonUndoItemProcessing: ["Undo"],
                    labelButtonRetryItemProcessing: ["Retry"],
                    labelButtonProcessItem: ["Upload"],
                }
            );
        }
    },
    methods: {
        getFiles() {
            return this.allowMultiple ? this.$refs[this.reference].getFiles() : this.$refs[this.reference].getFile();
        },
        init() {
            this.$emit("init", this.$refs[this.reference]);
        },
        warning(event) {
            this.$emit("warning", event);
        },
        error(event) {
            this.$emit("error", event);
        },
        addFileStart() {
            this.$emit("addFileStart");
        },
        addFileProgress() {
            this.$emit("addFileProgress");
        },
        addedFile() {
            this.$emit("addedFile", this.getFiles());
        },
        processFileStart(file) {
            this.$emit("processFileStart", file);
        },
        processFileProgress(file) {
            this.$emit("processFileProgress", file);
        },
        processFileAbort(file) {
            this.$emit("processFileAbort", file);
        },
        processFileFinished(file) {
            this.$emit("processFileFinished", file);
        },
        processFilesFinished() {
            this.$emit("processFilesFinished", this.getFiles());
        },
        removedFile() {
            this.$emit("removedFile", this.getFiles());
        },
        updatedFiles() {
            this.$emit("updatedFiles", this.getFiles());
        },
        fileClicked(file) {
            this.$emit("fileClicked", file);
        },
        clear() {
            this.$refs[this.reference].removeFiles();
        },
    },
};
</script>

<style>
.margin-center {
    margin: 0 auto;
}

.filepond--root {
    height: auto;
    margin: 0 auto;
}

.filepond--file-action-button {
    cursor: pointer;
}

/* the text color of the drop label*/
.filepond--drop-label label,
.filepond--drop-label {
    color: #cf2d30;
    cursor: pointer;
}

/* underline color for "Browse" button */
.filepond--label-action {
    text-decoration-color: #cf2d30;
}

/* the background color of the filepond drop area */
.filepond--panel-root {
    background-color: rgba(207, 45, 48, 0.1);
    color: #cf2d30;
}

/* the border radius of the drop area */
.filepond--panel-root {
    border-radius: 0.5em;
}

/* the border radius of the file item */
.filepond--item-panel {
    border-radius: 0.5em;
}

/* the background color of the file and file panel (used when dropping an image) */
.filepond--item-panel {
    background-color: #555;
}

/* the background color of the black action buttons */
.filepond--file-action-button {
    background-color: rgba(0, 0, 0, 0.5);
}

/* the color of the focus ring */
.filepond--file-action-button:hover,
.filepond--file-action-button:focus {
    box-shadow: 0 0 0 0.125em rgba(255, 255, 255, 0.9);
}

/* error state color */
[data-filepond-item-state*="error"] .filepond--item-panel,
[data-filepond-item-state*="invalid"] .filepond--item-panel {
    background-color: #dc3545;
}

[data-filepond-item-state="processing-complete"] .filepond--item-panel {
    background-color: #198754;
}

.filepond--panel-top:after,
.filepond--panel-bottom:before {
    height: 0px !important;
}

.filepond--credits {
    display: none !important;
}
</style>
