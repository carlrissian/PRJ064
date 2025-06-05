<template>
    <div  :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <label class="control-label" :for="id" v-text="label"></label>
        <div class="input-group time">
            <input type="text" :value="value" class="form-control timepicker" :id="id" :name="name" data-minute-step = "1">
            <div class="input-group-append">
                 <span class="input-group-text">
                    <i class="fa fa-hourglass-half"></i>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpTimePicker",
        props: {
            classNumber: String,
            label: String,
            value: String,
            id: String,
            name: String,
            placeholder: String,
            emptyDefault: {
                default: false,
                type: Boolean
            }
        },
        data() {
          return {
              el: null
          }
        },
        mounted() {
            this.el = $(`#${this.id}`);
            this.el.timepicker({
                timeFormat : 'h:mm:ss',
                showMeridian: false,
                icons:{
                  up: 'fa fa-angle-up',
                  down: 'fa fa-angle-down'
                }
            });
            if (this.emptyDefault) {
                this.el.val('');
            }
        }
    }
</script>

<style scoped>

</style>