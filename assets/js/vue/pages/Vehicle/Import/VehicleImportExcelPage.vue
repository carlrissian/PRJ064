<template>
  <fragment>

    <h1>{{ translations.header }}</h1>
    <div class="mb-3">
      <label for="formFile" class="form-label">{{ translations.label }}</label>
      <input @change="loadFile" class="form-control" type="file" accept=".xls,.xlsx" id="xls" ref="fileImput">
      <hr>
      <button @click="importExcel()" class="btn btn-primary" :disabled="isActive">{{
          translations.importButton
        }}
      </button>
      <view-vehicle-update v-show="showList" :list="list" :mesages="messages" :errors="errors"
                           :numberVehicles="numberVehicles" :num="num"/>
    </div>

  </fragment>
</template>

<script>
import Axios from "axios";
import ErpForm from "../../../components/form/ErpForm.vue";
import readXlsxFile from "read-excel-file";
import Loading from "../../../../../assets/js/utilities"
import ViewVehicleUpdate from "../ViewVehicleUpdate.vue";

export default {

  name: "VehicleImportExcelPage",
  components: {
    ViewVehicleUpdate,
    ErpForm
  },
  props: {
    vehicleList: null,
    vehicleStatusList: null

  },
  data() {
    return {
      translations: {},
      items: [],
      isActive: true,
      list: [],
      showList: false,
      messages: [],
      errors: [],
      itemResult: [],
      allCall: [],
      num: 0,
      numberVehicles: 0,
      allVehicles: [],
      vehicleStatus: [],



    }
  },
  mounted() {
    this.translations = translations;
    this.allVehicles = this.vehicleList;
    this.vehicleStatus = this.vehicleStatusList;

  },

  methods: {
    loadFile() {

      const input = document.getElementById('xls');
      this.num = 0;
      this.messages = [];
      this.list = [];
      this.errors = [];
      this.showList=false;

      readXlsxFile(input.files[0]).then((rows) => {
        rows.forEach(function (item,index){ //ADDED INDEX FROM EXEL TO ITEMS
          item.push(index+1);
        })
        this.items = rows;
        this.isActive = false;
        this.numberVehicles = this.items.length;
      });



    },

    importExcel() {
      this.$refs.fileImput.value = null;
      const self = this;
      self.num = 0;
      self.messages = [];
      self.list = [];
      self.errors = [];

      let collectionItems=this.fractionList(this.items,100);
      collectionItems[0].shift();//Delete row titles
      self.callVehicle(collectionItems);

    },


    callVehicle(collectionItems) {


      const self = this;

        Loading.starLoading();
      Axios.post(this.routing.generate('api.vehicle.import'), {
          item: collectionItems[0],
          vehicles: self.allVehicles,
          vehicleStatusList: self.vehicleStatus
        }).then(result => {

          Loading.endLoading();
          result.data.forEach((value, index) => {
            if (value.message) {
              self.messages = [{'success': value.message}];
              self.showList = true;
            }

            if (value.listVehiclesUpdate) {
              value.listVehiclesUpdate.forEach(item => {
                self.list.push(item)
              });
            }
            if (value.errors) {
              value.errors.forEach((err) => {
                self.errors.push({'error': err});
              });
            }
            collectionItems.shift();
            if (collectionItems.length > 0) {
              this.callVehicle(collectionItems)
            }else{
              self.updateVehicle();
            }


          });
        }).catch((error) => {
          console.log(error)
        });


    },

    updateVehicle() {

      if (this.list.length > 0) {

        let allVehicleUpdate = this.fractionList(this.list,50);
        let vehicles=[];

        allVehicleUpdate.forEach(async item => {
        vehicles.push({updateVehicle:item});
        });

        this.callSubProcess(vehicles);

      }

    },
    sendPostRequest(url,data) {
      return Axios.post(url, data);
    },

    callSubProcess(fleets){

      try {
        const postPromises = fleets.map((data) => this.sendPostRequest(this.routing.generate('api.importSystem.vehicleUpdate'),data));

        Promise.all(postPromises)
            .then((responses) => {

              responses.forEach((response, index) => {
                console.log('Respuesta de la solicitud ', response.data);
              });
            })
            .catch((error) => {
              console.error(error);
            });


      } catch (error) {
        console.error('Error', error)
      }
    },

    fractionList(valueRequest,maxNum) {

      let allValueRequest = [];
      let itemResult = [];
      let x = 1;
      valueRequest.forEach(function (item, index) { //Call Axios for each X  elements for load
        if (x <= maxNum) {
          itemResult.push(item);
        } else {
          x = 1;
          itemResult.push(item);
          allValueRequest.push(itemResult);
          itemResult = [];
        }
        x++;
      })
      if (itemResult.length > 0) {
        allValueRequest.push(itemResult)
      }

      return allValueRequest;
    },




    handleNotification(notification) {
      this.$refs.notifications.addNotification(notification);
    }
  }
}
</script>

<style scoped>

</style>