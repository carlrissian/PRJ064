<template>
    <bootstrap-table :ref="referer"
                     :columns="columns"
                     :options="optionsTable"
                     @onCheck="check"
                     @onUncheck="check"
                     @onCheckAll="check"
                     @onUncheckAll="check" />
</template>

<script>
    import Axios from 'axios';
    export default {
        name: "ErpAjaxTable",
        props: {
            columns: Array,
            options: Object,
            url: String,
            reference: String,
            filter: {
                type: Boolean,
                default: true
            },
            parameterDefault: {}
        },
        data() {
            return {
                items: null,
                search: '',
                optionsTable: {
                    sidePagination: 'server',
                    ajax: this.ajaxRequest
                },
                referer: ''
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
                Axios.get(this.getUrlByFilter(params)).then(resp => {
                    if (this.filter) {
                        this.$store.commit('filter/count', resp.data.total);
                    }
                    params.success(resp.data, null, {});
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
            }
        },
        watch: {
            '$store.state.filter.search': function() {
                this.search = this.$store.getters['filter/search'];
                this.$refs[this.referer].refresh();
            },
            '$store.state.filter.items':  function () {
                this.items = this.$store.getters['filter/items'];
                this.$refs[this.referer].refresh();
            },
            url(){
                this.$refs[this.referer].refresh();
            }
        }
    }
</script>

<style scoped>

</style>