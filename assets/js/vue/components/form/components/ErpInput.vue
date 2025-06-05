<template>
    <div :class="classNumber ? `col-md-${classNumber}` : 'col-md-3'">
        <div class="form-group">
            <label class="control-label" :for="id" v-text="label"></label>
            <div class="input-group">
                <input  @input="someHandler" :type="type" class="form-control" :name="name" :id="id" :value="value"
                        :placeholder="placeholder" :readonly="readOnly" :disabled="disabled" :min="min" :max="max" :title="title" :step="step" :required="required">
                <slot></slot>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpInput",
        props: {
            classNumber: String,
            id: String,
            type: String,
            name: String,
            label: String,
            value: [String, Number],
            placeholder: String,
            readOnly: String,
            min: String,
            max: String,
            title: String,
            step: String,
            disabled: {
                type: Boolean,
                default: false
            },
            required: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            someHandler(e) {
                this.$emit('changeUpdateInput', e);
            }
        }
    }
</script>
<style scoped>

</style>