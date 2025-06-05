<template>
    <!-- BootstrapVue Modal Doc oficial: https://bootstrap-vue.org/docs/components/modal -->
    <b-modal
        @show="$emit('onShowModal', $refs[reference])"
        @hide="$emit('onCloseModal', $refs[reference])"
        @hidden="$emit('onClosedModal', $refs[reference])"
        @keydown="$emit('onKeyPressedModal', $refs[reference])"
        @ok="useForm ? handleOk($event) : null"
        aria-label="erp-modal"
        :ref="reference"
        :id="id"
        :modal-class="modalClass"
        :title="title"
        :size="size"
        :centered="centered"
        :hide-backdrop="hideBackdrop"
        :hide-header="hideHeader"
        :hide-header-close="hideHeaderClose"
        :hide-footer="hideFooter"
        :button-size="buttonSize"
        :scrollable="scrollable"
        :no-close-on-esc="!closable"
        :no-close-on-backdrop="!closable"
    >
        <template v-show="!hideHeader" #modal-header>
            <slot name="header"></slot>
        </template>

        <template v-show="!hideHeaderClose" #modal-header-close>
            <slot name="header-close"></slot>
        </template>

        <!-- 
            FIXME no se puede hacer submit:
            No se pueden introducir los templates en la etiqueta form, el componente b-modal no lo permite.
            Si no se pueden juntar las templates de body y footer, no se puede hacer un submit tradicional.
            De momento, el submit se hará con un botón en el footer, que deberá emitir un evento al componente padre.
            No está funcionando el evento ok del b-modal, hay que reviasr mejor esto.
         -->
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
            <slot name="body"></slot>
            <!-- TODO comprobar si se usa form, si el form atiende con el submit en el footer -->
        </form>

        <slot v-else name="body"></slot>

        <template v-show="!hideFooter" #modal-footer>
            <!-- 
                INFO: si se utiliza el formulario (useForm = true), el botón submit deberá incluir en el evento click un emit al evento ok del modal.
                Ejemplo: @click="$refs.{nombre de la referencia}.$emit('ok')"
             -->
            <slot name="footer"></slot>
        </template>
    </b-modal>
</template>

<script>
export default {
    name: "ErpModal",
    props: {
        reference: {
            type: String,
            default: "erpModal",
        },
        id: {
            type: String,
            default: "erpModal",
        },
        modalClass: {
            type: [String, Array, Object],
            default: null,
        },
        size: {
            type: String,
            validator: (value) => ["sm", "md", "lg", "xl"].includes(value),
            // validator: (value) => ["sm", "md", "lg", "xl", "xxl"].includes(value),
            default: "lg",
        },
        centered: {
            type: Boolean,
            default: false,
        },
        buttonSize: {
            type: String,
            validator: (value) => ["sm", "md", "lg"].includes(value),
            default: "md",
        },
        hideBackdrop: {
            type: Boolean,
            default: false,
        },
        hideHeader: {
            type: Boolean,
            default: false,
        },
        hideHeaderClose: {
            type: Boolean,
            default: false,
        },
        hideFooter: {
            type: Boolean,
            default: false,
        },
        scrollable: {
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
    methods: {
        submitForm() {
            if (typeof this.submitPrevent === "function") this.submitPrevent();
        },
        handleOk(event) {
            console.log("into");
            event.preventDefault();
            this.submitPrevent();
        },
    },
};
</script>

<style scoped></style>
