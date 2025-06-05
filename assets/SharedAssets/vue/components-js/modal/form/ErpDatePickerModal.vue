<template>
  <div :class=" classNumber ? `col-md-${classNumber}` : 'col-md-4'">
    <div class="form-group">
      <date-picker-element :id="id" :name="name"
                           :placeholder="placeholder" :value="value" :format="format"
                           :limit-start-day="limitStartDay" :limit-end-day="limitEndDay"
                           @updateDatePicker="datePickerUpdated" :label="label"
      />
    </div>
  </div>
</template>

<script>
import DatePickerElement from "../../base/inputs/DatePicker.vue";
export default {
  name: "ErpDatePickerModal",
  components: {DatePickerElement},
  props: {
    classNumber: String,
    label: String,
    id: String,
    name: String,
    value: String,
    format: String,
    placeholder: String,
    limitStartDay: [Date, String],
    limitEndDay: [Date, String]
  },
  data() {
    return {
      timer: null,
      timeout: 1000
    }
  },
  methods: {
    datePickerUpdated(e) {
      this.$emit('updatedDatePicker', e);
    },
  },
}
</script>
