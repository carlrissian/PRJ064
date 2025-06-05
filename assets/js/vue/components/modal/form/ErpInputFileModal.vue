<template>
    <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
        <label class="control-label" :for="id" v-text="label"></label>
        <div class="custom-file">
            <input @change="processFile($event)"  type="file" class="custom-file-input" :name="name" :id="id" :lang="lang || 'es'">
            <label class="custom-file-label" :for="id" :id="id" v-text="labelFile || 'Selecciona archivo'"></label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpInputFileModal",
        props: {
            classNumber: String,
            id: String,
            name: String,
            label: String,
            lang: String,
            labelFile: String
        },
        methods: {
            processFile(event) {
                this.$emit('changeUpdateInput', event.target.files[0]);
            }
        }
    }
</script>

<style scoped>

</style>