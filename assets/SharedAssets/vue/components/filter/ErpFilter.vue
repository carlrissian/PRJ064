<template>
    <div :id="filterId">
        <erp-search-filter :show-count="showCount" :show-search="showSearch">
            <div class="col-10">
                <button @click="clickButton" type="button" id="btn-filters" class="btn btn-record">{{ message.filter }}<i class="fa fa-angle-down ml-3"></i> </button>
                <button @click="removeAll" type="button" id="btn-reset-filters-out" class="btn btn-record" :class="statusButtonRemove ? '' : 'collapse'">{{ message.filterButtonDeleteAll }}</button>
            </div>
        </erp-search-filter>
        <div :id="filtersId+'filters'"  class="row filters collapse mb-3">
            <div class="col">
                <div class="kt-portlet kt-portlet--solid-light mb-0">
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
                    <div class="kt-portlet__foot kt-portlet__foot--sm kt-align-right ">
                        <button @click="removeAll" type="button" id="btn-reset-filters-in" class="btn btn-font-light btn-outline-hover-light">{{ message.filterButtonDeleteAll }}</button>
                        <button @click="searchButton" type="button" id="btn-search" class="btn btn-font-light btn-outline-hover-light">{{ message.filterSearch }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="active-filters" class="row collapse show filters my-3">
            <div  class="col">
                <button v-if="items.length" v-for="item in items" :key="item.name" style="margin-bottom: 1em" type="button" class="btn btn-sm btn-light btn-pill mr-1 btn-filter-data" :data-target="item.name">
                    {{ item.label }}: {{ item.value }} <i @click="removeItem(item)" class="fa fa-times-circle fa-lg  ml-3"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import ErpSearchFilter from "./form/ErpSearchFilter";
export default {
    name: "ErpFilter",
    components: { ErpSearchFilter },
    props: {
        url: String,
        method: String,
        showSearch: Boolean,
        showCount: {
            type: Boolean,
            default: true
        },
        filterId: String,
        activateEnterKeySearch: {
            type: Boolean,
            default: true

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
            form: {},
            filtersId: '',
        }
    },
    mounted() {
        this.message = msg.filter;
        let filter = this.filterId ? '#'+this.filterId : '';

        this.filtersId = this.filterId ? this.filterId : '';

        this.elements = document.querySelectorAll( filter+' #form-search input,'+filter+' #form-search select');

        this.$nextTick(function () {
            this.filter = $('#'+this.filtersId +'filters');
            this.filterActive = $('#active-filters');
        })


        if(this.activateEnterKeySearch){
            $(document).on('keypress', (e) => {
                if(e.key === 'Enter') {
                    e.preventDefault();
                    this.searchButton();
                }
            });
        }

    },
    destroyed() {
        if(this.activateEnterKeySearch){
            $(document).off('keypress');
        }
    },
    methods: {
        clickButton() {
            this.showAndHide();
        },
        searchButton() {
            if (!this.fieldsIsEmpty()) {
                this.items = [];
                this.form = [];
                this.elements.forEach( el => {
                    if(el.type === 'search'){
                        return;
                    }

                    if (el.type === 'select-multiple') {
                        this.getValueMultipleSelect(el);
                        return;
                    }
                    if(el.type === 'select-one'){
                        this.getValueSelect(el);
                        return;
                    }
                    if(el.type === 'checkbox'){
                        if(el.checked) {
                            this.getValueCheckbox(el);
                        }
                        return;
                    }

                    if (el.value){
                        if(el.value === ''){
                            return;
                        }
                        const label = el.parentElement.parentElement.querySelector('label').innerText;
                        const value = this.getValue(el);
                        const name = el.getAttribute('name');
                        let valueEncoded = escape(value);
                        this.form[name] = valueEncoded;
                        this.items.push({label, value, name, el});

                    }
                });

                this.showAndHide();
                this.statusButtonRemove = this.items.length > 0;
                this.$store.commit('filter/items', this.form);
            }
        },
        getValueSelect(el) {
            if(el.value === ''){
                return;
            }
            const label = el.parentElement.querySelector('label').innerText;
            const value = el.options[el.selectedIndex].text;
            const name = el.getAttribute('name');
            this.form[name] = el.value;
            this.items.push({label, value, name, el});
        },
        getValueMultipleSelect(el) {
            const label = el.parentElement.parentElement.parentElement.querySelector('label').innerText;
            const value = el.nextSibling.title;

            const name = el.name;
            let arraySelected = value.split(',').map(i=>i.trim());
            if (value && value !== label && value !== 'Nothing selected' && value !== 'Select an option') {
                this.items.push({label, value, name, el});
                let ids = [];

                for(let i = 0; i < el.length; i++){
                    if(arraySelected.includes(el[i].text)){
                        ids.push(el[i].value);
                    }
                }
                if(ids.length > 0) {
                    this.form[name] = JSON.stringify(ids);
                }
            }
        },
        getValueCheckbox(el){
            const label = el.parentElement.parentElement.parentElement.querySelector('label').innerText;
            const value = el.checked;
            const name = el.getAttribute('name');
            this.form[name] = true;
            this.items.push({label, value, name, el});
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
            if(item.el.type === 'checkbox'){
                item.el.checked = false;
            }else{
                item.el.value = '';
            }
            this.items = this.items.filter( el =>  el.name !== item.name );
            delete this.form[item.name];
            this.statusButtonRemove = this.items.length > 0;
            this.$store.commit('filter/items', this.form);
        },
        removeAll() {
            this.elements.forEach( el => {
                if (el.type === 'select-multiple') {
                    if (el.value) {
                        el.value = '';
                        this.changedTextSelectMultipleRemove(el);
                    }
                }
                if(el.type === 'checkbox'){
                    el.checked = false;
                }
                else {
                    el.value = '';
                }
            });
            this.items = [];
            this.form = [];
            this.statusButtonRemove = false;
            if (!this.checkTagsEmpty()) {
                this.$store.commit('filter/items', this.form);
            }
        },
        changedTextSelectMultipleRemove(el) {
            //let title = el.parentElement.parentElement.parentElement.querySelector('label').innerText;
            //document.querySelector('.filter-option-inner-inner').innerHTML = "Nothing selected";
            let title = "Nothing selected";
            let elementList = document.querySelectorAll('.filter-option-inner-inner');
            let i;
            for (i = 0; i < elementList.length; i++) {
                elementList[i].innerHTML = title;
            }
            el.nextSibling.title = title;

        },
        showAndHide() {
            this.statusButtonRemove = this.items.length > 0 && this.filter.hasClass('show');
            this.filter.collapse('toggle');
            this.filterActive.collapse('toggle');

        },
        fieldsIsEmpty() {
            let empty = true;
            this.elements.forEach( el => {
                if(el.type === 'checkbox'){
                    if(el.checked) {
                        empty = false;
                    }
                    return;
                }
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