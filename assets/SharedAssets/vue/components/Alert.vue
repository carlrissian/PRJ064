<template>
    <div :class="`alert alert-${type} alert-custom fade show`" role="alert">
        <div class="alert-icon"><i :class="icon"></i></div>
        <div class="alert-text">
            <slot name="text"></slot>
        </div>
        <div v-if="closable" class="alert-close">
            <button @click="$emit('flush')" type="button" class="close" aria-label="Close">
                <span aria-hidden="true"><i class="la la-close"></i></span>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Alert",
    props: {
        type: {
            type: String,
            validator: function(value) {
                return ["primary", "secondary", "success", "danger", "warning", "info", "light", "dark"].includes(value);
            },
            default: "warning",
        },
        customIcon: {
            type: String,
            default: "",
        },
        closable: {
            type: Boolean,
            default: true,
        },
    },
    computed: {
        icon() {
            const options = {
                info: "la la-info-circle",
                warning: "la la-exclamation-triangle",
                danger: "la la-exclamation",
                success: "la la-check-circle",
            };
            return options[this.type] || this.customIcon;
        },
    },
};
</script>
<style scoped></style>
