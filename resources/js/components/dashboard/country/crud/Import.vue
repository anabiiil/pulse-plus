<template>
    <div class="text-start my-4">
        <router-link to="/dash/country" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Import Countries
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="importData" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">File</label>
                                        <v-file-input clearable v-model="file"
                                                      density="compact"
                                                      variant="outlined"></v-file-input>
                                        <span v-if="errors?.file" class="text-danger">{{ errors?.file }}</span>
                                    </div>

                                </div>
                                <div class="col-md-12 text-center my-4">
                                    <button type="submit" class="btn btn-success">Import</button>
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


// import eventBus from "../../../../main/event-bus.js";


import {useHead} from "@vueuse/head";

export default {
    setup() {
        useHead({
            title: 'Import Countries',
        });
    },
    data: () => ({
        formData: {
            file: null,
        },
        file: null,
        loading: false,
        errors: {},
    }),
    mounted() {
    },
    methods: {
        async importData() {
            this.resetErrors()
            if (this.checkValidation()) {
                axios.post(`countries/import`, {file:this.file},{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }).then((response) => {
                    // response.data.data.code
                    showSuccessToast('Country imported successfully');
                    this.$router.push('/dash/country');
                }).catch((error) => {
                    if (error?.response?.data?.message) {
                        this.errors = error.response.data.errors;
                        showErrorToast(error.response.data.message)
                    } else {
                        showErrorToast('Accurate error,please try again later')
                    }
                }).finally(() => {
                    this.loading = false;
                });


            } else {
                showErrorToast('Imported issue')
            }

        },

        checkValidation() {
            return true;

        },

        resetErrors() {
            for (let key in this.errors) {
                if (this.errors.hasOwnProperty(key)) {
                    this.errors[key] = null;
                }
            }
        },
        handleEvent(payload) {
            this.admin = payload.item;
        },

    },

}
</script>
