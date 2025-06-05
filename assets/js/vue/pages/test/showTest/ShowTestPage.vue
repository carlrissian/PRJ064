<template>
  <div class="row">
    <div class="col-md-12">
      <div id="kt_portlet" class="kt-portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
              {{ translations.title }}
            </h3>
          </div>
        </div>

        <div class="kt-portlet__body">
          <div class="row mt-3">
            <div class="form-group col-lg-3">
              <label>{{ translations.code }}:</label>
              <p class="form-control-static" v-text="test.code"></p>
            </div>
            <div class="form-group col-lg-3">
              <label>{{ translations.name }}:</label>
              <p class="form-control-static" v-text="test.name"></p>
            </div>
            <div class="form-group col-lg-3">
              <label>{{ translations.notes }}:</label>
              <p class="form-control-static" v-text="test.notes"></p>
            </div>
          </div>
          <div class="form-group row mt-3">
            <div class="col">
              <label>{{ translations.creationDate }}:</label>
              <p class="form-control-static" v-text="test.creationDate"/>
            </div>
            <div class="col">
              <label>{{ translations.editionDate }}:</label>
              <p class="form-control-static" v-text="test.editionDate"/>
            </div>
            <div class="col">
              <label>{{ translations.creationUserName }}:</label>
              <p class="form-control-static" v-text="test.creationUserName"/>
            </div>
            <div class="col">
              <label>{{ translations.editionUserName }}:</label>
              <p class="form-control-static" v-text="test.editionUserName"/>
            </div>
          </div>
        </div>
        <div class="kt-portlet__foot">
          <div class="kt-form__actions kt-align-right">
            <a @click="goList" class="btn btn-secondary">{{ translations.goList }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ShowTestPage",
  props: {
    test: {},
  },
  data() {
    return {
      translations: {}
    }
  },
  methods:{
    goList() {
      location.href = this.routing.generate('view.test.list');
    },
  },
  mounted() {
    this.translations = translationsTestShow;
  },
}
</script>

<style scoped>

</style>