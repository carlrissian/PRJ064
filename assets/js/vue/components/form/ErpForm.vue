<template>
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--bordered">
                <div class="kt-portlet__body">
                    <div class="kt-portlet kt-portlet--bordered">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title" v-text="title"></h3>
                            </div>
                        </div>
                        <form id="formMovement" class="kt-form" :action="url" :method="method" autocomplete="off" :id="id || 'filter-static-form'" enctype="multipart/form-data">
                            <template v-if="csrftoken">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_csrf_token" :value="csrftoken"/>
                            </template>
                            <div class="kt-portlet__body">
                                   <slot name="body"></slot>
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="text-right">
                                    <slot name="footer"></slot>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ErpForm",
        props: {
            title: String,
            url: String,
            method: String,
            id: String,
            csrftoken: String
        }
    }
</script>

<style scoped>

</style>