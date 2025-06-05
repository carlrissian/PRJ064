<template>
    <div v-bind:id="'condition['+ condition +']['+sliderName+']'" class="kt-nouislider"></div>
</template>

<script>
    export default {
        name: "ErpNoUiSlider",
        props: {
            condition: "",
            sliderName: "",
            inputValue: "",
            disableSlider: false,
            formatHours: false,
            startSlider: Number
        },
        methods: {

            convertValueToTime(value){

                let hours = this.convertToHour(value);
                let minutes = this.convertToMinute(value,hours);
                return this.formatHoursAndMinutes(hours,minutes);
            },
            convertToHour(value){
                return Math.floor(value / 60);
            },
            convertToMinute(value,hour){
                return Math.floor(value - hour * 60);
            },
            formatHoursAndMinutes(hours,minutes){
                if(hours.toString().length === 1) hours = '0' + hours;
                if(minutes.toString().length === 1) minutes = '0' + minutes;
                return hours+':'+minutes;
            },
        },
        mounted() {
            const vm = this;
            let slider = document.getElementById('condition['+this.condition+']['+this.sliderName+']');
            let elementValue = document.getElementById('condition['+this.condition+']['+this.inputValue+']');
            let formattedValue;

            if(this.formatHours === false) {
                let FormatNum = wNumb({decimals: 0});

                noUiSlider.create(slider, {
                    start: this.startSlider,
                    connect: true,
                    tooltips: FormatNum,
                    step: 15,
                    range:{
                        'min': 0,
                        'max': 1440
                    }
                });
                slider.noUiSlider.on('update', function (value, handle) {
                    elementValue.value = Math.round(value);
                    formattedValue = Math.round(value);
                });
            }else{
                noUiSlider.create(slider,{
                    start:this.startSlider,
                    connect:true,
                    tooltips: true,
                    format: {
                        to: function (value) {
                            return vm.convertValueToTime(value);
                        },
                        from: Number,
                    },
                    step: 15,
                    range:{
                        'min': 0,
                        'max': 1440
                    }
                });
                slider.noUiSlider.on('update', function(value, handle) {
                    elementValue.value = value;
                    formattedValue = value;
                });
            }
            elementValue.value = formattedValue;
            $(slider).attr('disabled', this.disableSlider);

        },
    }
</script>

<style scoped>

</style>