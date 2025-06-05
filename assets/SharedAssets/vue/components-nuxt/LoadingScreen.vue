<template>
    <b-overlay
        ref="overlay"
        id="loading-screen"
        :show="isLoading"
        z-index="10000"
        variant="transparent"
        :opacity="1"
        blur="0.5rem"
        :rounded="false"
        spinner-variant="primary"
        fixed
        style="height: 100vh"
    >
        <template #overlay>
            <div class="text-center">
                <img src="/media/img/loading.gif" :alt="$t('common.loading')" style="height: 10rem" />
                <h5
                    v-if="!['', null, undefined].includes($store.getters['loading/getMessage'])"
                    class="mt-6 text-shadow"
                    v-text="$store.getters['loading/getMessage']"
                ></h5>
            </div>
        </template>
        <slot></slot>
    </b-overlay>
</template>

<script>
export default {
    name: "LoadingScreen",
    computed: {
        isLoading() {
            return this.$store.getters["loading/isVisible"];
        },
    },
    watch: {
        isLoading(newValue) {
            document.body.style.overflow = newValue ? "hidden" : "";
            document.body.style.pointerEvents = newValue ? "none" : "";
            document.body.style.cursor = newValue ? "wait" : "auto";
        },
    },
    mounted() {
        if (this.isLoading) {
            document.body.style.overflow = "hidden";
            document.body.style.pointerEvents = "none";
            document.body.style.cursor = "wait";
        }
    },
    beforeDestroy() {
        // Restaurar el cursor y eventos al desmontar el componente
        document.body.style.overflow = "";
        document.body.style.pointerEvents = "";
        document.body.style.cursor = "auto";
    },
};
</script>

<style scoped>
.text-shadow {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    color: white;
}
</style>
