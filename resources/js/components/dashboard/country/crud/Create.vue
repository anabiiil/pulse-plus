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
                    Create Country
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="store">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name En</label>
                                        <input type="text" class="form-control" v-model="formData.name.en">
                                        <span class="text-danger" v-if="errors?.name?.en">{{ errors?.name?.en }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name Ar</label>
                                        <input type="text" class="form-control" v-model="formData.name.ar">
                                        <span class="text-danger" v-if="errors?.name?.ar">{{ errors?.name?.ar }}</span>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">region En</label>
                                        <input type="text" class="form-control" v-model="formData.region.en">
                                        <span class="text-danger"
                                              v-if="errors?.region?.en">{{ errors?.region?.en }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">region Ar</label>
                                        <input type="text" class="form-control" v-model="formData.region.ar">
                                        <span class="text-danger"
                                              v-if="errors?.region?.ar">{{ errors?.region?.ar }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">sub region En</label>
                                        <input type="text" class="form-control" v-model="formData.subregion.en">
                                        <span class="text-danger"
                                              v-if="errors?.subregion?.en">{{ errors?.subregion?.en }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">sub region Ar</label>
                                        <input type="text" class="form-control" v-model="formData.subregion.ar">
                                        <span class="text-danger"
                                              v-if="errors?.subregion?.ar">{{ errors?.subregion?.ar }}</span>
                                    </div>
                                </div>



                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Code</label>
                                        <input type="text" class="form-control" v-model="formData.iso3">
                                        <span class="text-danger"
                                              v-if="errors?.iso3">{{ errors?.iso3 }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">phone code</label>
                                        <input type="text" class="form-control" v-model="formData.phone_code">
                                        <span class="text-danger"
                                              v-if="errors?.phone_code">{{ errors?.phone_code }}</span>
                                    </div>
                                </div>





                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Status</label>
                                        <v-switch v-model="formData.status" density="compact"
                                                  :color="formData.status ? 'success' : ''" label=""></v-switch>

                                        <span class="text-danger" v-if="errors?.status">{{ errors?.status }}</span>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center my-4">
                                    <button type="submit" class="btn btn-success">Create</button>
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


import {useHead} from "@vueuse/head";



export default {

    setup() {
        useHead({
            title: 'Create Country',
        });
    },
    props: {
        id: {
            required: true,
        },
    },
    data: () => ({
        errors: {},
        selectedStatus: null,
        formData: {
            name: {
                en: null,
                ar: null
            },
            region: {
                en: null,
                ar: null
            },
            subregion: {
                en: null,
                ar: null
            },
            iso3: null,
            phone_code: null,
            status: null,
        },
        item: null,
        errorList: '',
        loading: false,
    }),
    methods: {
        async store() {
            this.resetErrors()
            if (this.checkValidation()) {
                axios.post(`/countries/create`, this.formData).then((response) => {
                    showSuccessToast('Country created successfully');
                    this.$router.push('/dash/country');
                }).catch((error) => {
                    this.errors = error?.response?.data?.errors;
                    if (error?.response?.data?.message) {
                        // showErrorToast(error.response.data.message)
                        for (let key in error?.response?.data?.errors) {
                            this.errorList += error?.response?.data?.errors[key] + '<br>';
                        }
                        showErrorToast(this.errorList)
                    } else {
                        showErrorToast('Accurate error,please try again later')
                    }
                }).finally(() => {
                    this.loading = false;
                });
            }

        },



        checkValidation() {
            // if (this.formData.password !== this.formData.password_confirmation) {
            //     this.errors.password_confirmation = "the password confirmation must be same password"
            //     return false;
            // }
            return true;
        },
        resetErrors() {
            for (let key in this.errors) {
                if (this.errors.hasOwnProperty(key)) {
                    this.errors[key] = null;
                }
            }
        }
    },
    mounted() {
    }

}
</script>
