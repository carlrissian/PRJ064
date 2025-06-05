<template>
  <div>
    <h1 v-if="showCount"> Registros totales: {{ $store.getters['filter/count'] }}</h1>
    <div class="row mb-3">
      <slot></slot>
      <div class="col-2"  v-if="showSearch">
        <div class="form-group mb-0">
          <div class="kt-input-icon kt-input-icon--right">
            <button @click="searchButton" type="button" class="btn btn-primary">Search</button>
            <span class="kt-input-icon__icon kt-input-icon__icon--right">
                            <span><i class="la la-search"></i></span>
                        </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ErpSearchFilter",
  props: {
    showSearch: {
      type: Boolean,
      default: false
    },
    showCount: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      search: '',
    }
  },
  methods: {
    searchButton() {
      this.$store.commit('filter/search', this.search);
    }
  },
  watch: {
    search() {
      this.$store.commit('filter/search', this.search);
    }
  },
}
</script>
