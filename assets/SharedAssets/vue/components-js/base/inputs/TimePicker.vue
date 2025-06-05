<template>
  <div :class="divClass">
    <label :class="labelClass" :for="id" v-text="label"></label>
    <div class="input-group time">
      <input
        @input="onInputChange"
        @change="onChange"
        @blur="formatAndSetTime"
        @keydown.enter="formatAndSetTime"
        type="time"
        :name="name"
        :ref="reference"
        :id="id"
        class="form-control"
        :placeholder="placeholder"
        :readonly="readonly"
        :disabled="disabled"
        :required="required"
        v-model="time"
      />
      <div class="input-group-append">
                <span class="input-group-text">
                    <i class="fa fa-hourglass-half"></i>
                </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TimePicker",
  props: {
    name: String,
    id: String,
    reference: String,
    value: String,
    format: {
      type: String,
      default: "HH:mm",
    },
    interval: {
      type: Number,
      default: null,
    },
    minTime: {
      type: String,
      default: null,
    },
    maxTime: {
      type: String,
      default: null,
    },
    startTime: {
      type: String,
      default: null,
    },
    defaultTime: {
      type: String,
      default: null,
    },
    label: String,
    placeholder: {
      type: String,
      default: "hh:mm",
    },
    readonly: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
    divClass: {
      type: String,
      default: null,
    },
    labelClass: {
      type: String,
      default: "control-label",
    },
  },
  data() {
    return {
      time: this.value,
      tempTime: null,
    };
  },
  methods: {
    onInputChange(e) {
      this.tempTime = e.target.value; // tempTime = input value
    },
    onChange(e) {
      this.$emit("onChangeTimePicker", e);
    },
    formatAndSetTime() {
      if (this.tempTime) {
        let timeSequence = this.tempTime; // tempTime = input value

        const regex1 = /^(\d{1,2})(\d{2})$/;
        const regex2 = /^(\d{1,2})(\d{2})(\d{2})$/;
        const regex3 = /^(\d{1,2})(\d{2})([a-zA-Z]{2})$/;
        const regex4 = /^(\d{1,2})(\d{2})(\d{2})([a-zA-Z]{2})$/;
        if (regex1.test(timeSequence)) {
          timeSequence = timeSequence.replace(regex, "$1:$2");
        }
        if (regex2.test(timeSequence)) {
          timeSequence = timeSequence.replace(regex, "$1:$2:$3");
        }
        if (regex3.test(timeSequence)) {
          timeSequence = timeSequence.replace(regex, "$1:$2 $3");
        }
        if (regex4.test(timeSequence)) {
          timeSequence = timeSequence.replace(regex, "$1:$2:$3 $4");
        }

        // Validación de la hora pasando por distintos formatos
        let formats = ["hh:mm", "hh:mm:ss", "hh:mm a", "hh:mm:ss a"];
        let momentTime = null;

        /**
         * @author adrian.gaman
         * TODO: Según he consultado la documentación de Moment.js, si a moment se le pasara el array debería de funcionar. El problema es que no lo hace
         */
        for (let formattmp of formats) {
          momentTime = moment(timeSequence, formattmp);
          if (momentTime.isValid()) {
            break;
          }
        }

        // Si la hora es válida
        if (momentTime && momentTime.isValid()) {
          // Creación del string de hora
          let time = momentTime.format(this.format);
          // Actualización del timepicker
          this.time = time;
          // this.element.timepicker("update", time); Comento esta línea porque v-model ya se encarga de asignar el valor automáticamente a timepicker
          // console.log(time, this.element.timepicker("getTime"));
          this.$emit("updatedTimePicker", time);
        }
        this.tempTime = null;
      }
    },

  },
  watch: {
    value() {
      this.time = this.value;
    },
  },
};
</script>

<style lang=""></style>
