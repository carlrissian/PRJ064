<template>
    <fragment>
        <section class="update-file">
            <div class="for-ProgressBar"></div>

            <div class="UppyForm">
            </div>
        </section>
    </fragment>
</template>

<script>
    import Uppy from "@uppy/core"
    import FileInput from '@uppy/file-input';
    import ProgressBar from'@uppy/progress-bar';
    import XHRUpload from'@uppy/xhr-upload';
    require('@uppy/core/dist/style.min.css');
    require('@uppy/file-input/dist/style.min.css');
    require('@uppy/progress-bar/dist/style.min.css');
    export default {
        name: "ErpUppyUploader",
        components: {
            Uppy,
            FileInput,
            ProgressBar,
            XHRUpload
        },
        props: {
            labelButtonUpload: "",
            url: ""
        },
        data(){
            return {
                uppy: new Uppy({autoProceed: true})
            }
        },
        mounted() {
            this.uppy.use(FileInput, {
                    target: '.update-file .UppyForm',
                    pretty: true,
                    locale: {
                        strings: {
                            chooseFiles: this.labelButtonUpload
                        }
                    }
                })
                .use(XHRUpload, {
                    endpoint: this.url,
                    formData: true,
                    fieldName: 'file',
                    headers: {
                        'Cache-Control': 'no-cache, must-revalidate',
                        'Accept': 'text/html'
                    },
                    limit: 1,
                    getResponseData: function getResponseData(responseText) {
                        return responseText;
                    },
                })
                .use(ProgressBar, {target: '.update-file .for-ProgressBar', hideAfterFinish: false});

            this.uppy.on('upload-success', (file, response) => {
                this.$emit('getContent', response.body);
            });

            this.uppy.on('complete', (file, response) => {
                this.uppy.reset();
            });

        },
        watch:{
            url(){
                this.uppy.getPlugin('XHRUpload').setOptions({
                    endpoint: this.url
                })
            }
        }
    }
</script>

<style scoped>

</style>