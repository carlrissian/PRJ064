<template>
  <test-form :path="routing.generate('api.test.update',{id: id})" method="post" :test="test"/>
</template>

<script>
import TestForm from "../components/TestForm";
export default {
  name: "EditTestPage",
  components: {TestForm},
  props:{
    id: null,
    test: null
  }

}
</script>

<style scoped>

</style>