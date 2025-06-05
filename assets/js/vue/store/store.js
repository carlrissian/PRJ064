import Vue from "vue";
import Vuex from 'vuex';
import { filter } from './modules/filter';
import { erpFilter } from './modules/erpFilter';
import { overlapDate } from "./modules/overlapDate";


Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        filter,
        erpFilter,
        overlapDate
    }
});


