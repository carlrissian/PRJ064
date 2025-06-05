<template>
    <div :class="classNumber ? `col-md-${classNumber} margin-center` : 'col-md-3 margin-center'">
        <label class="control-label" :for="id" v-text="label"></label>
        <file-pond
            ref="filepond"
            v-if="server"
            :id="id"
            :name="name"
            :allowRevert="allowRevert"
            :ref="reference"
            :label-idle="labelIdle"
            :accepted-file-types="acceptedFiles"
            :allow-multiple="allowMultiple"
            maxFileSize="50MB"
            :server="{
                url: server,
                process: {
                    headers: {
                        'X-CSRF-Token': this.token,
                    },
                    onload: (response) => this.$emit('ajaxOnload', response),
                    onerror: (response) => this.$emit('ajaxError', response),
                },
            }"
            @addfile="addFile"/>

        <file-pond
            v-if="!server"
            :id="id"
            :name="name"
            :allowRevert="allowRevert"
            :ref="reference"
            :label-idle="labelIdle"
            maxFileSize="50MB"
            @addfile="addFile"
            @removefile="removeFile"
            :accepted-file-types="acceptedFiles"
            :allow-multiple="allowMultiple"/>
    </div>
</template>

<script>
import vueFilePond, {setOptions} from 'vue-filepond';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);
export default {
    name: "ErpInputFileStaticFilter",
    components: {FilePond},
    props: {
        server: String,
        reference: {
            type: String,
            default: 'pong'
        },
        classNumber: String,
        id: String,
        name: String,
        label: String,
        labelIdle: {
            type: String,
            default: 'Drag & Drop your file or <span class="filepond--label-action">Browse</span>'
        },
        acceptedFiles: String,
        allowMultiple: {
            type: Boolean,
            default: false
        },
        allowRevert: {
            type: Boolean,
            default: false
        },
        token: String
    },
    mounted() {
        if (this.server) {
            setOptions({
                labelFileTypeNotAllowed: ['Tipo de archivo invalido'],
                labelInvalidField: ['El campo contiene archivos inválidos'],
                labelFileWaitingForSize: ['Esperando el tamaño'],
                labelFileSizeNotAvailable: ['Tamaño no disponible'],
                labelFileCountSingular: ['archivo en la lista'],
                labelFileCountPlural: ['archivo en la lista'],
                labelFileLoading: ['Cargando'],
                labelFileAdded: ['Añadido'],
                labelFileLoadError: ['Error durante la carga'],
                labelFileRemoved: ['Eliminado'],
                labelFileRemoveError: ['Error durante la eliminación'],
                labelFileProcessing: ['Cargando'],
                labelFileProcessingComplete: ['Carga completa'],
                labelFileProcessingAborted: ['Carga cancelada'],
                // labelFileProcessingError: ['Error durante la carga'],
                labelFileProcessingRevertError: ['Error durante la reversión'],
                labelTapToCancel: ['pulse para cancelar'],
                labelTapToRetry: ['golpecito para reintentar'],
                labelTapToUndo: ['golpear para deshacer'],
                labelButtonRemoveItem: ['Eliminar'],
                labelButtonAbortItemLoad: ['Abortar'],
                labelButtonRetryItemLoad: ['Reintenta'],
                labelButtonAbortItemProcessing: ['Cancelar'],
                labelButtonUndoItemProcessing: ['Deshacer'],
                labelButtonRetryItemProcessing: ['Reintenta'],
                labelButtonProcessItem: ['Subir'],
            })
        }
        this.$emit('refFile', this.$refs[this.reference]);
    },
    methods: {
        addFile() {
            let files = this.allowMultiple ? this.$refs[this.reference].getFiles() : this.$refs[this.reference].getFile();
            this.$emit('addFile', files);
        },
        removeFile() {
            this.$emit('removeFile');
        },
        clearList() {
            this.$refs.pong.removeFiles();
        }
    },
}

</script>

<style>
.margin-center {
    margin: 0 auto
}

.filepond--root {
    height: auto;
    margin: 0 auto;
}

.filepond--file-action-button {
    cursor: pointer;
}

/* the text color of the drop label*/
.filepond--drop-label label, .filepond--drop-label {
    color: #5d78ff;
    cursor: pointer;
}

/* underline color for "Browse" button */
.filepond--label-action {
    text-decoration-color: #5d78ff;
}

/* the background color of the filepond drop area */
.filepond--panel-root {
    background-color: rgba(93, 120, 255, .1);
    color: #5d78ff;
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
[data-filepond-item-state*='error'] .filepond--item-panel,
[data-filepond-item-state*='invalid'] .filepond--item-panel {
    background-color: red;
}

[data-filepond-item-state='processing-complete'] .filepond--item-panel {
    background-color: green;
}

.filepond--panel-top:after, .filepond--panel-bottom:before {
    height: 0px !important;
}

</style>