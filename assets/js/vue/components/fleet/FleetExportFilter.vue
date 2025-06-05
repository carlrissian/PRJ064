<template>
    <erp-filter-export ref="erpFilterExport" :show-search-button="false" show-filters>
        <!-- Provider -->
        <erp-multiple-select-picker-filter
            name="providerId"
            id="providerId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.provider"
        >
            <option
                v-for="option in selectList.providerList"
                :value="option.id"
                v-text="`${Formatter.formatField(option.providerSAPId)} | ${Formatter.formatField(option.name)}`"
            ></option>
        </erp-multiple-select-picker-filter>
        <!--  -->

        <!-- BBCustomer -->
        <erp-multiple-select-picker-filter
            name="bbCustomerId"
            id="bbCustomerId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.bbCustomer"
        >
            <option
                v-for="option in selectList.providerList"
                :value="option.id"
                v-text="`${Formatter.formatField(option.customerSAPId)} | ${Formatter.formatField(option.name)}`"
            ></option>
        </erp-multiple-select-picker-filter>
        <!--  -->

        <!-- Purchase type -->
        <erp-multiple-select-picker-filter
            name="purchaseTypeId"
            id="purchaseTypeId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.purchaseType"
            :options="selectList.purchaseTypeList"
        />
        <!--  -->

        <!-- Sale method -->
        <erp-multiple-select-picker-filter
            name="saleMethodId"
            id="saleMethodId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.saleMethod"
            :options="selectList.saleMethodList"
        />
        <!--  -->

        <!-- Brand -->
        <erp-multiple-select-picker-filter
            @updatedMultipleSelectPicker="(brandSelection = $event), filterModelList()"
            name="brandId"
            id="brandId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.brand"
            :value="brandSelection"
            :options="filteredBrandList"
        />
        <!--  -->

        <!-- Model -->
        <erp-multiple-select-picker-filter
            @updatedMultipleSelectPicker="(modelSelection = $event), filterTrimList()"
            name="modelId"
            id="modelId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.model"
            :value="modelSelection"
            :options="filteredModelList"
        />
        <!--  -->

        <!-- Trim -->
        <erp-multiple-select-picker-filter
            @updatedMultipleSelectPicker="trimSelection = $event"
            name="trimId"
            id="trimId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.trim"
            :value="trimSelection"
            :options="filteredTrimList"
        />
        <!--  -->

        <!-- Car Group -->
        <erp-multiple-select-picker-filter
            name="carGroupId"
            id="carGroupId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.carGroup"
            :options="selectList.carGroupList"
        />
        <!--  -->

        <!-- Vehicle Type -->
        <erp-multiple-select-picker-filter
            name="vehicleTypeId"
            id="vehicleTypeId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.vehicleType"
            :options="selectList.vehicleTypeList"
        />
        <!--  -->

        <!-- ACRISS -->
        <erp-multiple-select-picker-filter
            name="acrissId"
            id="acrissId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.acriss"
            :options="selectList.acrissList"
        />
        <!--  -->

        <!-- GearBox -->
        <erp-multiple-select-picker-filter
            name="gearBoxId"
            id="gearBoxId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.gearBox"
            :options="selectList.gearBoxList"
        />
        <!--  -->

        <!-- Motorization Type -->
        <erp-multiple-select-picker-filter
            name="motorizationTypeId"
            id="motorizationTypeId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.motorizationType"
            :options="selectList.motorizationTypeList"
        />
        <!--  -->

        <!-- First Registration Date -->
        <erp-date-picker-filter
            @updatedDatePicker="firstRegistrationDateFrom = $event"
            name="firstRegistrationDateFrom"
            id="firstRegistrationDateFrom"
            divClass="col-md-3 mb-3"
            :label="translations.fields.firstRegistrationDateFrom"
            :limit-end-day="firstRegistrationDateTo"
        />

        <erp-date-picker-filter
            @updatedDatePicker="firstRegistrationDateTo = $event"
            name="firstRegistrationDateTo"
            id="firstRegistrationDateTo"
            divClass="col-md-3 mb-3"
            :label="translations.fields.firstRegistrationDateTo"
            :limit-start-day="firstRegistrationDateFrom"
        />
        <!--  -->

        <!-- Last Registration Date -->
        <erp-date-picker-filter
            @updatedDatePicker="lastRegistrationDateFrom = $event"
            name="lastRegistrationDateFrom"
            id="lastRegistrationDateFrom"
            divClass="col-md-3 mb-3"
            :label="translations.fields.lastRegistrationDateFrom"
            :limit-end-day="lastRegistrationDateTo"
        />

        <erp-date-picker-filter
            @updatedDatePicker="lastRegistrationDateTo = $event"
            name="lastRegistrationDateTo"
            id="lastRegistrationDateTo"
            divClass="col-md-3 mb-3"
            :label="translations.fields.lastRegistrationDateTo"
            :limit-start-day="lastRegistrationDateFrom"
        />
        <!--  -->

        <!-- Delivery Date -->
        <erp-date-picker-filter
            @updatedDatePicker="deliveryDateFrom = $event"
            name="deliveryDateFrom"
            id="deliveryDateFrom"
            divClass="col-md-3 mb-3"
            :label="translations.fields.deliveryDateFrom"
            :limit-end-day="deliveryDateTo"
        />

        <erp-date-picker-filter
            @updatedDatePicker="deliveryDateTo = $event"
            name="deliveryDateTo"
            id="deliveryDateTo"
            divClass="col-md-3 mb-3"
            :label="translations.fields.deliveryDateTo"
            :limit-start-day="deliveryDateFrom"
        />
        <!--  -->

        <!-- Return Date -->
        <erp-date-picker-filter
            @updatedDatePicker="returnDateFrom = $event"
            name="returnDateFrom"
            id="returnDateFrom"
            divClass="col-md-3 mb-3"
            :label="translations.fields.returnDateFrom"
            :limit-end-day="returnDateTo"
        />

        <erp-date-picker-filter
            @updatedDatePicker="returnDateTo = $event"
            name="returnDateTo"
            id="returnDateTo"
            divClass="col-md-3 mb-3"
            :label="translations.fields.returnDateTo"
            :limit-start-day="returnDateFrom"
        />
        <!--  -->

        <!-- First Rent Date -->
        <erp-date-picker-filter
            @updatedDatePicker="firstRentDateFrom = $event"
            name="firstRentDateFrom"
            id="firstRentDateFrom"
            divClass="col-md-3 mb-3"
            :label="translations.fields.firstRentDateFrom"
            :limit-end-day="firstRentDateTo"
        />

        <erp-date-picker-filter
            @updatedDatePicker="firstRentDateTo = $event"
            name="firstRentDateTo"
            id="firstRentDateTo"
            divClass="col-md-3 mb-3"
            :label="translations.fields.firstRentDateTo"
            :limit-start-day="firstRentDateFrom"
        />
        <!--  -->

        <!-- Renting End Date -->
        <erp-date-picker-filter
            @updatedDatePicker="rentingEndDateFrom = $event"
            name="rentingEndDateFrom"
            id="rentingEndDateFrom"
            divClass="col-md-3 mb-3"
            :label="translations.fields.rentingEndDateFrom"
            :limit-end-day="rentingEndDateTo"
        />

        <erp-date-picker-filter
            @updatedDatePicker="rentingEndDateTo = $event"
            name="rentingEndDateTo"
            id="rentingEndDateTo"
            divClass="col-md-3 mb-3"
            :label="translations.fields.rentingEndDateTo"
            :limit-start-day="rentingEndDateFrom"
        />
        <!--  -->

        <!-- Reception Location -->
        <erp-multiple-select-picker-filter
            name="receptionLocationId"
            id="receptionLocationId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.receptionLocation"
            :options="selectList.locationList"
        />
        <!--  -->

        <!-- Vehicle Status -->
        <erp-multiple-select-picker-filter
            name="vehicleStatusId"
            id="vehicleStatusId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.vehicleStatus"
            :options="selectList.vehicleStatusList"
        />
        <!--  -->

        <!-- Actual Location -->
        <erp-multiple-select-picker-filter
            name="actualLocationId"
            id="actualLocationId"
            divClass="col-md-3 mb-3"
            :label="translations.fields.actualLocation"
            :options="selectList.locationList"
        />
        <!--  -->

        <!-- Creation Date -->
        <erp-date-picker-filter
            @updatedDatePicker="creationDateFrom = $event"
            name="creationDateFrom"
            id="creationDateFrom"
            divClass="col-md-3 mb-3"
            :label="translations.fields.creationDateFrom"
            :limit-end-day="creationDateTo"
        />

        <erp-date-picker-filter
            @updatedDatePicker="creationDateTo = $event"
            name="creationDateTo"
            id="creationDateTo"
            divClass="col-md-3 mb-3"
            :label="translations.fields.creationDateTo"
            :limit-start-day="creationDateFrom"
        />
        <!--  -->

        <!-- En Vigor -->
        <erp-check-box-filter
            name="operative"
            id="operative"
            divClass="col-md-3 mb-3 centered"
            :label="translations.fields.operative"
        />
        <!--  -->

        <!-- Sin matrícula -->
        <erp-check-box-filter
            name="noLicensePlate"
            id="noLicensePlate"
            divClass="col-md-3 mb-3 centered"
            :label="translations.fields.noLicensePlate"
        />
        <!--  -->
    </erp-filter-export>
</template>

<script>
import Loading from "../../../../assets/js/utilities.js";
import Formatter from "../../../../SharedAssets/js/formatter.js";
import ErpFilter from "../../../../js/vue/components/filter/ErpFilter.vue";
import ErpFilterExport from "../filter/ErpFilterExport.vue";
import ErpCheckBoxFilter from "../../../../SharedAssets/vue/components/filter/form/ErpCheckBoxFilter.vue";
import ErpDatePickerFilter from "../../../../SharedAssets/vue/components/filter/form/ErpDatePickerFilter2.vue";
import ErpMultipleSelectPickerFilter from "../../../../SharedAssets/vue/components/filter/form/ErpMultipleSelectPickerFilter.vue";

export default {
    name: "FleetExportFilter",
    components: {
        ErpFilter,
        ErpFilterExport,
        ErpCheckBoxFilter,
        ErpDatePickerFilter,
        ErpMultipleSelectPickerFilter,
    },
    data() {
        return {
            Formatter,
            translations,

            firstRegistrationDateFrom: null,
            firstRegistrationDateTo: null,
            lastRegistrationDateFrom: null,
            lastRegistrationDateTo: null,
            deliveryDateFrom: null,
            deliveryDateTo: null,
            returnDateFrom: null,
            returnDateTo: null,
            firstRentDateFrom: null,
            firstRentDateTo: null,
            rentingEndDateFrom: null,
            rentingEndDateTo: null,
            creationDateFrom: null,
            creationDateTo: null,

            selectList: {
                providerList: [],
                purchaseTypeList: [],
                saleMethodList: [],
                brandList: [],
                modelList: [],
                trimList: [],
                carGroupList: [],
                vehicleTypeList: [],
                acrissList: [],
                gearBoxList: [],
                motorizationTypeList: [],
                locationList: [],
                vehicleStatusList: [],
            },
            filteredBrandList: [],
            filteredModelList: [],
            filteredTrimList: [],

            brandSelection: [],
            modelSelection: [],
            trimSelection: [],
        };
    },
    async mounted() {
        await this.getSelectLists();
    },
    methods: {
        async getSelectLists() {
            Loading.starLoading();

            this.axios
                .all([
                    this.axios.get(this.routing.generate("api.provider.selectList")),
                    this.axios.get(this.routing.generate("api.purchaseType.selectList")),
                    this.axios.get(this.routing.generate("api.saleMethod.selectList")),
                    this.axios.get(this.routing.generate("api.brand.selectList")),
                    this.axios.get(this.routing.generate("api.model.selectList")),
                    this.axios.get(this.routing.generate("api.trim.selectList")),
                    this.axios.get(this.routing.generate("api.carGroup.selectList")),
                    this.axios.get(this.routing.generate("api.vehicleType.selectList")),
                    this.axios.get(this.routing.generate("api.acriss.selectList")),
                    this.axios.get(this.routing.generate("api.gearBox.selectList")),
                    this.axios.get(this.routing.generate("api.motorizationType.selectList")),
                    this.axios.get(this.routing.generate("api.location.selectList")),
                    this.axios.get(this.routing.generate("api.vehicleStatus.selectList")),
                ])
                .then(
                    this.axios.spread(
                        (
                            provider,
                            purchaseType,
                            saleMethod,
                            brand,
                            model,
                            trim,
                            carGroup,
                            vehicleType,
                            acriss,
                            gearBox,
                            motorizationType,
                            location,
                            vehicleStatus
                        ) => {
                            this.selectList.providerList = provider.data;
                            this.selectList.purchaseTypeList = purchaseType.data;
                            this.selectList.saleMethodList = saleMethod.data;
                            this.selectList.brandList = brand.data;
                            this.selectList.modelList = model.data;
                            this.selectList.trimList = trim.data;
                            this.selectList.carGroupList = carGroup.data;
                            this.selectList.vehicleTypeList = vehicleType.data;
                            this.selectList.acrissList = acriss.data;
                            this.selectList.gearBoxList = gearBox.data;
                            this.selectList.motorizationTypeList = motorizationType.data;
                            this.selectList.locationList = location.data;
                            this.selectList.vehicleStatusList = vehicleStatus.data;

                            this.selectList.brandList.sort((a, b) => {
                                let nameA = a.name.toLowerCase();
                                let nameB = b.name.toLowerCase();
                                if (nameA < nameB) return -1;
                                if (nameA > nameB) return 1;
                                return 0;
                            });
                            this.selectList.modelList.sort((a, b) => {
                                let nameA = a.name.toLowerCase();
                                let nameB = b.name.toLowerCase();
                                if (nameA < nameB) return -1;
                                if (nameA > nameB) return 1;
                                return 0;
                            });
                            this.selectList.trimList.sort((a, b) => {
                                let nameA = a.name.toLowerCase();
                                let nameB = b.name.toLowerCase();
                                if (nameA < nameB) return -1;
                                if (nameA > nameB) return 1;
                                return 0;
                            });
                            this.selectList.carGroupList.sort((a, b) => {
                                let nameA = a.name.toLowerCase();
                                let nameB = b.name.toLowerCase();
                                if (nameA < nameB) return -1;
                                if (nameA > nameB) return 1;
                                return 0;
                            });
                            this.selectList.acrissList.sort((a, b) => {
                                let nameA = a.name.toLowerCase();
                                let nameB = b.name.toLowerCase();
                                if (nameA < nameB) return -1;
                                if (nameA > nameB) return 1;
                                return 0;
                            });
                            this.selectList.locationList.sort((a, b) => {
                                let nameA = a.name.toLowerCase();
                                let nameB = b.name.toLowerCase();
                                if (nameA < nameB) return -1;
                                if (nameA > nameB) return 1;
                                return 0;
                            });
                            this.selectList.vehicleStatusList.sort((a, b) => {
                                let nameA = a.name.toLowerCase();
                                let nameB = b.name.toLowerCase();
                                if (nameA < nameB) return -1;
                                if (nameA > nameB) return 1;
                                return 0;
                            });

                            this.filteredBrandList = this.selectList.brandList;
                            this.filteredModelList = this.selectList.modelList;
                            this.filteredTrimList = this.selectList.trimList;

                            Loading.endLoading();
                        }
                    )
                )
                .catch((error) => {
                    console.error(error);
                    Loading.endLoading();
                });
        },
        filterModelList() {
            this.filteredModelList = this.selectList.modelList.filter((model) => this.brandSelection.includes(model.brandId));
            this.filteredModelList = this.filteredModelList.length > 0 ? this.filteredModelList : this.selectList.modelList;
            this.modelSelection = this.modelSelection.filter((modelId) =>
                this.filteredModelList.some((model) => model.id == modelId)
            );
            this.filterTrimList();
        },
        filterTrimList() {
            this.filteredTrimList = this.selectList.trimList.filter((trim) => this.modelSelection.includes(trim.modelId));
            this.filteredTrimList = this.filteredTrimList.length > 0 ? this.filteredTrimList : this.selectList.trimList;
            this.trimSelection = this.trimSelection.filter((trimId) => this.filteredTrimList.some((trim) => trim.id == trimId));
        },
    },
};
</script>
<style>
.centered {
    /* justify-items: center; */
    align-content: center;
}
</style>
