<template>
  <div :class="divClass">
    <label :class="labelClass" :for="id" v-text="label"></label>
    <select
      @change="onChange"
      :name="name"
      :ref="reference"
      :id="id"
      class="form-control"
      :readonly="readonly"
      :disabled="disabled"
      :required="required"
      v-model="selection"
    >
      <slot></slot>
    </select>
  </div>
</template>

<script>
export default {
  name: "SingleSelectPicker",
  props: {
    name: String,
    id: String,
    reference: String,
    value: [Number, String, Array, Object],
    label: String,
    placeholder: {
      type: String,
      default: "Select an option",
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
      selection: this.value,
    };
  },
  methods: {
    onChange(e) {
      this.$emit("onChangeSelectPicker", e);
      this.$emit("updatedSelectPicker", this.selection);
    },
  },
  watch: {
    value() {
      this.selection = this.value;
    },
  },
};
</script>

<style></style>
