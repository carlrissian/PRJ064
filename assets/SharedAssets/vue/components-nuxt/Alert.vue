<template>
    <b-alert
        @dismissed="dismissCountDown = 0"
        @dismiss-count-down="countDownChanged"
        :show="countdown ? dismissCountDown : show"
        :dismissible="closable"
        :variant="type"
        fade
    >
        <div class="d-flex align-items-center justify-content-start">
            <div class="h3 m-0 mr-10">
                <b-icon :icon="icon" />
            </div>
            <div>
                <slot name="text"></slot>
            </div>
        </div>
        <!-- FIXME tratar de cambiar variant por color personalizado, o cambiar estilo de variant a mostrar en alter -->
        <b-progress
            v-if="countdown"
            :variant="type"
            :max="countdownTime"
            :value="dismissCountDown"
            class="mt-5"
            height="4px"
        ></b-progress>
    </b-alert>
</template>

<script>
export default {
    name: "Alert",
    props: {
        type: {
            type: String,
            validator: function (value) {
                return ["primary", "secondary", "success", "danger", "warning", "info", "light", "dark"].includes(value);
            },
            default: "warning",
        },
        customIcon: {
            type: String,
            default: "",
        },
        show: {
            type: Boolean,
            default: true,
        },
        closable: {
            type: Boolean,
            default: true,
        },
        countdown: {
            type: Boolean,
            default: false,
        },
        countdownTime: {
            type: Number,
            default: 5,
        },
    },
    data() {
        return {
            dismissCountDown: this.countdownTime,
        };
    },
    computed: {
        icon() {
            const options = {
                info: "info-circle",
                warning: "exclamation-triangle",
                danger: "exclamation-lg",
                success: "check-circle",
            };
            return options[this.type] || this.customIcon;
        },
    },
    methods: {
        // FIXME ver si se puede hacer el countdown en décimas
        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown;
        },
    },
};
</script>
<style scoped></style>
