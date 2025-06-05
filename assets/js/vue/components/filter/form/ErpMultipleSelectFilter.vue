<template>
    <div :class="fillIn ? 'col-lg-12' : 'col-lg-3'">
        <label :for="id" v-text="label"></label>
        <div class="kt-input-icon">
                <select :type="type" class="form-control kt-selectpicker" :name="name" :id="id" multiple data-size="5" data-live-search="true">
                    <slot></slot>
                </select>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpMultipleSelectFilter",
        props: {
            id: String,
            type: String,
            name: String,
            label: String,
            value: Array,
            dataForAjax: Array,
            defaultText: String,
            fillIn: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                el: null
            }
        },
        mounted() {
            this.el = $(`#${this.id}`);
            this.el.selectpicker({
                noneSelectedText : this.defaultText ?? '',
                actionsBox: true
            });
        },
        watch: {
            value() {
                this.el.val(this.value);
                this.el.selectpicker("refresh");
            },
            dataForAjax() {
                this.dataForAjax.forEach((item, key) => {
                    let obj = {};
                    if(typeof item === 'object') {
                        obj = {
                            value: item.id ? item.id : item.code,
                            text: item.name ? item.name : (item.internalName ? item.internalName : item.commercialName),
                        };
                    } else {
                        obj = {
                            value: key,
                            text: item
                        }
                    }
                    this.el.append($("<option>", obj));
                    this.el.selectpicker("refresh");
                });
            }
        }
    }
</script>
<style scoped>

</style>