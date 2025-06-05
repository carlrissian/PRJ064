<template>
    <div>
        <erp-search-filter :show-count="showCount" :show-search="showSearch">
            <div class="col-10">
                <button @click="clickButton" type="button" id="btn-filters" class="btn btn-dark kt-label-bg-color-4">{{ message.filter }}<i class="fa fa-angle-down ml-3"></i> </button>
                <button @click="removeAll" type="button" id="btn-reset-filters-out" class="btn btn-dark kt-label-bg-color-4" :class="statusButtonRemove ? '' : 'collapse'">{{ message.filterButtonDeleteAll }}</button>
            </div>
        </erp-search-filter>
        <div id="filters"  class="row filters collapse mb-3">
            <div class="col">
                <div class="kt-portlet kt-portlet--solid-dark kt-label-bg-color-2 mb-0">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="fa fa-filter"></i></span>
                            <h3 class="kt-portlet__head-title">{{ message.filterTitle }}</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <form :action="url" class="form-horizontal" autocomplete="off" id="form-search" :method="method">
                            <div class="row">
                                <slot></slot>
                            </div>
                        </form>
                    </div>
                    <div class="kt-portlet__foot kt-portlet__foot--sm kt-align-right kt-label-bg-color-4">
                        <button @click="removeAll" type="button" id="btn-reset-filters-in" class="btn btn-font-light btn-outline-hover-light">{{ message.filterButtonDeleteAll }}</button>
                        <button @click="searchButton" type="button" id="btn-search" class="btn btn-font-light btn-outline-hover-light">{{ message.filterSearch }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="active-filters" class="row collapse show filters my-3">
            <div  class="col">
                <button v-if="items.length" v-for="item in items" :key="item.name" style="margin-bottom: 1em" type="button" class="btn btn-sm btn-dark kt-label-bg-color-4 btn-pill mr-1 btn-filter-data" :data-target="item.name">
                    {{ item.label }}: {{ item.value }} <i @click="removeItem(item)" class="fa fa-times-circle fa-lg  ml-3"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import ErpSearchFilter from "./form/ErpSearchFilter";
    export default {
        name: "ErpFilterColumn",
        components: { ErpSearchFilter },
        props: {
            url: String,
            method: String,
            showSearch: Boolean,
            showCount: {
                type: Boolean,
                default: true
            },
            isColumn: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                message: {},
                items: [],
                elements: null,
                statusButtonRemove: false,
                filter: null,
                filterActive: null,
                form: {}
            }
        },
        mounted() {
            this.message = msg.filter;
            this.elements = document.querySelectorAll('#form-search input, #form-search select');
            this.filter = $('#filters');
            this.filterActive = $('#active-filters');
        },
        methods: {
            clickButton() {
                if (this.isColumn) {
                    this.showAndHideColumn();
                } else {
                    this.showAndHide();
                }
            },
            searchButton() {
                if (!this.fieldsIsEmpty()) {
                    this.items = [];
                    this.form = [];
                    this.elements.forEach( el => {
                        if (el.type === 'select-multiple') {
                            this.getValueMultipleSelect(el);
                            return;
                        }
                        if (el.value) {
                            const label = el.parentElement.parentElement.parentElement.querySelector('label').innerText;
                            const value = this.getValue(el);
                            const name = el.getAttribute('name');
                            this.form[name] = el.value;
                            this.items.push({label, value, name, el});
                        }
                    });
                    if (this.isColumn) {
                        this.showAndHideColumn();
                    } else {
                        this.showAndHide();
                    }
                    this.statusButtonRemove = this.items.length > 0;
                    this.$store.commit('filter/items', this.form);
                }
            },
            getValueMultipleSelect(el) {
                const label = el.parentElement.parentElement.parentElement.querySelector('label').innerText;
                const value = el.nextSibling.title;
                const name = el.name;
                const id = el.id;
                let arraySelected = value.split(', ');
                this.$store.commit('filter/columns', []);
                if (value && value !== label) {
                    if (id !== 'columnsId') {
                        this.items.push({label, value, name, el});
                    }
                    let ids = [];
                    el.forEach(item => {
                        if (arraySelected.includes(item.text)) {
                            ids.push(item.value);
                        }
                    });
                    if (id !== 'columnsId') {
                        this.form[name] = JSON.stringify(ids);
                    } else {
                        this.$store.commit('filter/columns', ids);
                    }
                }
            },
            getValue(el) {
                switch (el.nodeName) {
                    case 'SELECT':
                        return el.options[el.selectedIndex].text;
                    default:
                        return el.value;
                }
            },
            removeItem(item) {
                if (item.el.type === 'select-multiple') {
                    this.changedTextSelectMultipleRemove(item.el);
                }
                item.el.value = '';
                this.items = this.items.filter( el =>  el.name !== item.name );
                delete this.form[item.name];
                this.statusButtonRemove = this.items.length > 0;
                this.$store.commit('filter/items', this.form);
            },
            removeAll() {
                this.elements.forEach( el => {
                    if (el.value) {
                        el.value = '';
                        if (el.type === 'select-multiple') {
                            this.changedTextSelectMultipleRemove(el);
                        }
                    }
                });
                this.items = [];
                this.form = [];
                this.statusButtonRemove = false;
                if (!this.checkTagsEmpty()) {
                    this.$store.commit('filter/columns', []);
                    this.$store.commit('filter/items', this.form);
                }
            },
            changedTextSelectMultipleRemove(el) {
                let title = el.parentElement.parentElement.parentElement.querySelector('label').innerText;
                document.querySelector('.filter-option-inner-inner').innerHTML = title;
                el.nextSibling.title = title;
            },
            showAndHide() {
                this.statusButtonRemove = this.items.length > 0 && this.filter.hasClass('show');
                this.filter.collapse('toggle');
                this.filterActive.collapse('toggle');
            },
            showAndHideColumn() {
                this.statusButtonRemove = this.items.length > 0 && this.filter.hasClass('show');
                if (this.filter.is(":visible")) {
                    this.filter.hide();
                } else {
                    this.filter.slideDown();
                }
                if (this.filterActive.is(":visible")) {
                    this.filterActive.hide();
                } else {
                    this.filterActive.slideDown();
                }
            },
            fieldsIsEmpty() {
                let empty = true;
                this.elements.forEach( el => {
                    if (el.value) {
                        empty = false;
                    }
                });
                return empty;
            },
            checkTagsEmpty() {
                return document.querySelectorAll('#active-filters i').length === 0;
            }
        }
    }
</script>

<style scoped>

</style>