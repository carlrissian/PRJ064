<template>
    <fragment>
        <notifications position="top right"></notifications>
        <bootstrap-table :ref="referer"
                         :columns="columns"
                         :options="optionsTable"
                         @onCheck="check"
                         @onUncheck="check"
                         @onCheckAll="check"
                         @onUncheckAll="check" />
    </fragment>
</template>

<script>
import Axios from 'axios';
export default {
    name: "ErpAjaxTable",
    props: {
        columns: {
            type: Array,
            required: true
        },
        options: {
            type: Object,
            required: true
        },
        url: {
            type: String,
            required: true
        },
        reference: String,
        filter: {
            type: Boolean,
            default: true
        },
        parameterDefault: Object,
        store: {
            type: String,
            default: 'filter'
        },
    },
    data() {
        return {
            items: null,
            mostrar: null,
            search: '',
            optionsTable: {
                sidePagination: 'server',
                ajax: this.ajaxRequest
            },
            referer: '',
            restartOffset: false
        }
    },
    created() {
        this.referer = this.reference || 'table';
        this.optionsTable = {...this.optionsTable, ...this.options}
    },
    mounted() {
        this.$emit('referer', this.$refs[this.referer]);
    },
    methods: {
        ajaxRequest(params) {
            $("#loading").show();
            if(this.restartOffset){
                params.data.offset = 0;
                this.restartOffset = false;
            }

            Axios.get(this.getUrlByFilter(params)).then(resp => {
                
                if (this.filter) {
                    this.$store.commit('filter/count', resp.data.total);
                }
                this.$emit('mostrar', resp.data.rows.length);
                this.$emit('items', resp.data);
                params.success(resp.data, null, {});
                $("#loading").hide();
            }).catch(error => {
                $("#loading").hide();
                this.$notify({
                    type: 'error',
                    title: 'Error',
                    text: error.response.statusText,
                })
            });
        },
        getUrlByFilter(params) {
            let queryString = '';
            this.getParameterFilterSearch(params);
            queryString = this.getParameterFilterInputs(queryString);
            queryString += Object.keys(params.data).map(key => key + '=' + params.data[key]).join('&');
            if (this.parameterDefault) {
                queryString += '&' + Object.keys(this.parameterDefault).map(key => key + '=' + this.parameterDefault[key]).join('&');
            }
            if(this.url.includes("?")){
                return `${this.url}&${queryString}`;
            }else {
                return `${this.url}?${queryString}`;
            }
        },
        getParameterFilterSearch(params) {
            if (this.search !== '') {
                params.data.search = this.search;
            }
        },
        getParameterFilterInputs(queryString) {
            if (this.items) {
                queryString = Object.keys(this.items).map(key => key + '=' + this.items[key]).join('&') + '&';
            }
            return queryString;
        },
        check() {
            this.$emit('check', this.$refs[this.referer]);
        },
        reload(){
            this.$refs[this.referer].refresh();
        }
    },
    computed: {
        itemsStore() {
            return this.$store.getters[`${this.store}/items`];
        },
        searchStore() {
            return this.$store.getters[`${this.store}/search`];
        }
    },
    watch: {
        searchStore(value) {
            this.search = value;
            this.$refs[this.referer].refresh();
        },
        itemsStore(value) {
            this.restartOffset = true;
            this.items = value;
            this.$refs[this.referer].refresh({pageNumber: 1 });
        }
    }
}
</script>

<style scoped>

</style>