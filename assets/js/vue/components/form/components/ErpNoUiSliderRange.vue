<template>
    <div v-bind:id="'condition['+ condition +']['+sliderName+']'" class="kt-nouislider"></div>
</template>

<script>
    export default {
        name: "ErpNoUiSliderRange",
        props: {
            condition: "",
            sliderName: "",
            nameMin: "",
            nameMax: "",
            disableSlider: Boolean,
            startMin: Number,
            startMax: Number
        },
        mounted() {
            let slider = document.getElementById('condition['+this.condition+']['+this.sliderName+']');
            let elementMin = document.getElementById('condition['+this.condition+']['+this.nameMin+']');
            let elementMax = document.getElementById('condition['+this.condition+']['+this.nameMax+']');
            let formattedValueMin;
            let formattedValueMax;

            let FormatNum = wNumb({decimals: 0});
            noUiSlider.create(slider, {
                start: [this.startMin, this.startMax],
                connect: true,
                tooltips: [FormatNum, FormatNum],
                steps: 1,
                range: {
                    'min': 18,
                    'max': 99
                }
            });
            slider.noUiSlider.on('update', function (values, handle) {
                elementMin.value = Math.round(values[0]);
                elementMax.value = Math.round(values[1]);
                formattedValueMin = Math.round(values[0]);
                formattedValueMax = Math.round(values[1]);
            });

            elementMin.value = formattedValueMin;
            elementMax.value = formattedValueMax;
            $(slider).attr('disabled', this.disableSlider);
        }
    }
</script>

<style scoped>

</style>