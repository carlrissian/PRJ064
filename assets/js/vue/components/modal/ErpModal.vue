<template>
    <div class="modal fade detail" :id="modalId ? modalId : 'erpModal'" tabindex="-1" role="dialog" aria-labelledby="modal-detail-label" aria-hidden="true">
        <div :class="'modal-dialog modal-'+size" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-detail-label" v-text="title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot name="body"></slot>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default  {
        name: "ErpModalSelect",
        props: {
            modalId: String,
            title: String,
            size: {
                default: 'lg',
                type: String
            }
        },
        mounted(){
            let that = this;
            let modalElement = $('#'+this.modalId);
            modalElement.on('hide.bs.modal', function () {
                that.$emit('modalToggle', false);
            });
            modalElement.on('show.bs.modal', function () {
                that.$emit('modalToggle', true);
            });
        }
    }
</script>

<style scoped>
    .modal-dialog.modal-xxl {
        max-width: 95% !important;
    }
</style>