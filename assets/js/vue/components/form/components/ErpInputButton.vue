<template>
    <div :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <div class="form-group">
            <label>{{ labelComponent }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn btn-primary" type="button" data-toggle="modal" :data-target="modalId" v-on:click="$emit('initInputButtonTarget', inputButtonTarget)">{{label}}</button>
                </div>
                <input type="text" name="complementTxt" class="form-control" disabled :value="complementName ? complementName : null">
                <input type="hidden" :name="nameId" v-on:click="removeItem" class="form-control complement-id" :value="complementCode ? complementCode : null">
                <div class="input-group-append">
                    <button class="btn btn-secondary pr-2" type="button" v-on:click="removeItem"><i class="flaticon2-cross"></i></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpInputButton",
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
        methods:{
            removeItem: function (event){
                $("#btn"+this.inputButtonTarget+" input[name=complementTxt]").val("");
                $("#btn"+this.inputButtonTarget+" input[name=complement"+this.inputButtonTarget+"]").val("").prop('disabled',true);
            }
        }
    }
</script>

<style scoped>

</style>