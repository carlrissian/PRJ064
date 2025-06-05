/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');
require('bootstrap');
window.Sticky = require('sticky-js');
window.Cookies = require('js-cookie');
window.PerfectScrollbar = require('perfect-scrollbar').default;
window.swal = require('sweetalert2');
window.toastr = require('toastr');
require('block-ui');
require('bootstrap-table');
require('bootstrap-table/dist/bootstrap-table-locale-all');
require('webpack-jquery-ui');
window.validate = require('jquery-validation');
window.moment = require('moment');
require('bootstrap-select');
require('bootstrap-timepicker');
require('bootstrap-datepicker');
require('bootstrap-daterangepicker');
require('bootstrap-timepicker');
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.es');
require('bootstrap-datepicker/js/locales/bootstrap-datepicker.en-GB');
require('clockpicker/dist/bootstrap-clockpicker');
window.noUiSlider = require('nouislider');
window.wNumb =require('wnumb');

import Vue from 'vue';
import '../SharedAssets/js/shared.js';
import 'bootstrap-table/dist/bootstrap-table.js';
import 'bootstrap-table/dist/bootstrap-table-locale-all';
import BootstrapTable from 'bootstrap-table/dist/bootstrap-table-vue.esm';
import Notifications from 'vue-notification';
import { store } from './vue/store/store';
const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import Axios from 'axios';

Routing.setRoutingData(routes);
Vue.prototype.routing = Routing;
Vue.prototype.axios = Axios;
Vue.component('BootstrapTable', BootstrapTable);
Vue.config.productionTip = false;
Vue.use(Notifications);
import Fragment from 'vue-fragment';
Vue.use(Fragment.Plugin);

new Vue({
    el: '#app',
    store,
    components: {
        'FleetImportPage': ()=>import('./vue/pages/fleet/Import/FleetImportPage'),
        'FleetExportPage': ()=>import('./vue/pages/fleet/Export/FleetExportPage'),
        'VehicleImportExcelPage': ()=>import('./vue/pages/Vehicle/Import/VehicleImportExcelPage'),
        'VehicleExportExcelPage': ()=>import('./vue/pages/Vehicle/Export/VehicleExportExcelPage'),

    }
});