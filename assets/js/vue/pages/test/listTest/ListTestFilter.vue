<template>
  <erp-filter>
    <erp-input-filter :label="translations.name" name="name" id="name" aria-valuetext=""/>
  </erp-filter>
</template>

<script>
  import ErpFilter from "../../../components/filter/ErpFilter";
  import ErpInputFilter from "../../../components/filter/form/ErpInputFilter";
  export default {
      name: "ListTestFilter",
      components: {
        ErpInputFilter, ErpFilter
      },
      data(){
          return{
            translations: {}
          }
      },
      mounted() {
          this.translations = translationsTestList;
      }
  }
</script>

<style scoped>

</style>