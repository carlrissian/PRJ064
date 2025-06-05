<template>
    <div :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <div class="form-group">
            <label>{{ labelComponent }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn btn-secondary btn-sm" type="button" data-toggle="modal" :data-target="modalId" v-on:click="$emit('initInputButtonTarget', inputButtonTarget)">{{label}}</button>
                </div>
                <input @change="someHandler" type="text" name="complementTxt" disabled class="form-control" :value="complementName">
                <input hidden type="number" :name="nameId" class="form-control complement-id" :value="complementCode ? complementCode : null">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpInputButtonNoRemove",
        props: {
            labelComponent: String,
            classNumber: String,
            modalId: String,
            label: String,
            inputButtonTarget: String,
            complementName: String,
            complementCode: Number
        },
        data() {
            return {
                nameId: "complement"+this.inputButtonTarget
            }
        },
        methods: {
            someHandler(e) {
                this.$emit('changeUpdateInput', e);
            }
        },
    }
</script>

<style scoped>

</style>