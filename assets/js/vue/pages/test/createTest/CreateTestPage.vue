<template>
  <test-form :path="routing.generate('api.test.store')" method="post" :test="test"/>
</template>

<script>
  import TestForm from "../components/TestForm";
  export default {
    name: "CreateTestPage",
    components: {TestForm},
    props:{
      test: null
    }

}
</script>

<style scoped>

</style>