<template>
    <div
        @keydown="onKeyPressed($event)"
        @click="onClickOutside($event)"
        :ref="reference"
        :id="id"
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="erp-modal"
        aria-hidden="true"
    >
        <div :class="`modal-dialog modal-${size} ` + (centered ? 'modal-dialog-centered' : '')" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-text="title"></h5>

                    <slot name="header"></slot>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form
                    v-if="useForm"
                    @submit.prevent="submitForm"
                    ref="form"
                    :id="`${id}Form`"
                    class="kt-form"
                    :action="url"
                    :method="method"
                    :enctype="enctype"
                    :autocomplete="autocomplete ? 'on' : 'off'"
                >
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </form>

                <div v-else>
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
/**+
 * TODO
 * Revisar atributos de un formulario
 * Ver si el evento submit.prevent se puede dejar vacío. Si no hacer un v-if
 */
export default {
    name: "ErpModal",
    props: {
        id: {
            type: String,
            default: "erpModal",
        },
        reference: {
            type: String,
            default: "erpModal",
        },
        size: {
            type: String,
            validator: (value) => ["sm", "md", "lg", "xl", "xxl"].includes(value),
            default: "lg",
        },
        centered: {
            type: Boolean,
            default: false,
        },
        closable: {
            type: Boolean,
            default: true,
        },
        title: String,

        useForm: {
            type: Boolean,
            default: false,
        },
        url: String,
        method: {
            type: String,
            validator: (value) => ["GET", "POST", "PUT", "DELETE"].includes(value),
        },
        enctype: {
            type: String,
            default: "multipart/form-data",
        },
        autocomplete: {
            type: Boolean,
            default: false,
        },
        submitPrevent: {
            type: Function,
            required: false,
            default: null,
        },
    },
    mounted() {
        $(`#${this.id}`).on("shown.bs.modal", this.onOpen);
        $(`#${this.id}`).on("hidden.bs.modal", this.onClose);
    },
    methods: {
        onKeyPressed(event) {
            if (this.closable) {
                if (event.keyCode == 27) {
                    this.onClose();
                }
            } else {
                event.preventDefault();
                event.stopPropagation();
            }
        },
        onClickOutside(event) {
            if (this.closable) {
                if (event.target === this.$refs[this.reference]) {
                    this.onClose();
                }
            } else {
                event.preventDefault();
                event.stopPropagation();
            }
        },
        onOpen() {
            this.$emit("onOpenModal", this.id);
        },
        onClose() {
            this.$emit("onCloseModal", this.id);
        },
        submitForm() {
            if (typeof this.submitPrevent === "function") this.submitPrevent();
        },
    },
};
</script>

<style scoped>
.modal-dialog.modal-xxl {
    max-width: 95% !important;
}
</style>
