<template>

  <div class="mt-5" v-show="showList">
    <div v-for="item in mesages">
      <div class="bg-primary p-2 text-white m-1" v-if="item.success">{{ item.success }}</div>
    </div>

    <div v-if="errors.length>0">
      <div class="mt-3 mb-3">

        <div class="bg-danger p-2 text-white m-1 div-message" v-on:click="downLoadErrors(errors)" style="cursor: pointer">
          Download errors from your excel to a text file. Click here.
        </div>

        <div :class="[!showErr?'bg-danger p-2 text-white m-1 div-message':'bg-success p-2 text-white m-1 div-message']" v-on:click="showErrors" style="cursor: pointer;">
          {{!showErr?'View the error list. Click here.  ↓':'Hiden errors. Click here. ↑'}}
        </div>



      </div>

      <div v-show="showErr" v-for="item in errors">
        <div class=" p-2 text-danger m-1" v-if="item.error">{{ item.error }}</div>
      </div>

    </div>
    <div><hr><h1> Total rows excel : {{numberVehicles-1}}  <span style="color: red;float: right">Errors: {{errors.length}}</span></h1><hr></div>

    <div v-if="list.length>0">
      <h1>Total vehicles update : {{list.length}} </h1>
      <div class="table-responsive">
        <table class="table">
          <thead class="bg-light sticky-top">
          <tr>
            <th>Number</th>
            <th>License Plate</th>
            <th>Vehicle Status</th>
            <th>Actual km</th>
            <th>Actual Fuel</th>
            <th>Actual Batery</th>
          </tr>
          </thead>

          <tr v-for="(item, index) in list" :key="index">
            <td>{{index+1}}</td>
            <td>{{ item.licensePlate }}</td>
            <td>{{ item.vehicleStatus.name }}</td>
            <td>{{ item.actualKms }}</td>
            <td>{{ item.actualCombustible }}</td>
            <td>{{ item.actualBateria }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>

</template>

<script>

export default {
  name: "ViewVehicleUpdate",
  components: {},
  props: {
    list: null,
    mesages: null,
    errors: null,
    numberVehicles: null,
    num:null,
    showList:null
  },
  data() {
    return {
      showErr: false
    }
  },

  methods: {
    showErrors() {
      this.showErr=!this.showErr;

    },
    downLoadErrors(errors) {
      let valueTxt = [];
      errors.forEach(item => {
        valueTxt.push(item.error + "\n")
      })
      const blob = new Blob(valueTxt, {type: 'text/plain'});
      const url = URL.createObjectURL(blob);

      const link = document.createElement('a');
      link.href = url;
      link.setAttribute('download', 'errors.txt');
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }

  }


}
</script>

<style scoped>


.table-responsive {
  max-height: 600px;
}
.div-message:hover{
  background: red !important;
}

</style>