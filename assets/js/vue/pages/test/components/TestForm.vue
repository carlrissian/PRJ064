<template>
    <fragment>
        <notifications position="top right"></notifications>

        <erp-form :title="translations.title" :method="method" :url="path">
        <div slot="body">
          <div class="row">
            <erp-input class-number="3" id="code" :label="translations.code" name="code" :value="code" />
            <erp-input class-number="3" id="name" :label="translations.name" name="name" :value="name" />
            <erp-textarea class-number="6" id="notes" :label="translations.notes" name="notes" :value="notes" />
          </div>
            <div class="form-group row mt-3" v-if="test">
              <div v-if="test.creationUserName">
                <div class="col">
                  <label>{{ translations.creationUserName }}:</label>
                  <p class="form-control-static" v-text="test.creationUserName"/>
                  <label>{{ translations.creationDate }}:</label>
                  <p class="form-control-static" v-text="test.creationDate"/>
                </div>
              </div>
              <div v-if="test.editionUserName">
                <div class="col">
                  <label>{{ translations.editionUserName }}:</label>
                  <p class="form-control-static" v-text="test.editionUserName"/>

                  <label>{{ translations.editionDate }}:</label>
                  <p class="form-control-static" v-text="test.editionDate"/>
                </div>
              </div>

            </div>
          </div>
        <template slot="footer">
          <div class="kt-align-right">
            <button class="btn btn-primary">{{translations.buttonCancel}}</button>
            <button type="button" @click="sendForm" style="" class="btn btn-primary">{{translations.buttonSave}}</button>
          </div>
        </template>
      </erp-form>
    </fragment>
</template>
<script>

  import ErpForm from "../../../components/form/ErpForm";
  import ErpInput from "../../../components/form/components/ErpInput";
  import ErpTextarea from "../../../components/form/components/ErpTextarea";
  import Axios from "axios";
  import Loading from "../../../../../assets/js/utilities";

  export default {
      name: "TestForm",
      components: {ErpTextarea, ErpInput, ErpForm},
      props:{
          path: null,
          method: null,
          test: {}
      },
      data(){
        return{
          code: '',
          name: '',
          notes: '',
          translations: {}
        }
      },
      mounted() {
          this.translations = translationsTest;
          this.code = this.test ? this.test.code : '';
          this.name = this.test ? this.test.name : '';
          this.notes = this.test ? this.test.notes : '';
      },
      methods: {
          async sendForm() {

              let component = this;
              Loading.starLoading();

              await Axios.post(this.path,{
                      code: $('#code').val(),
                      name: $('#name').val(),
                      notes: $('#notes').val(),
              }).then( function(result){

                    location.href = component.routing.generate('test.list');

              }).catch(
                  function(error){
                      component.showNotification("error", component.txt.errorOnStore+': ' +error.response.data.message);
                  }
              );

              Loading.endLoading();
          },
          showNotification(type = '', text = '', duration = 5000) {
              this.$notify({
                  text,
                  type,
                  duration
              });
          },
      }
  }
</script>