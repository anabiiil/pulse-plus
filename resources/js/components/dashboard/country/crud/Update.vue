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
                    Update County ({{ formData?.name?.en }})
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="update">
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
                                    <button type="submit" class="btn btn-success">Update</button>
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


import eventBus from "../../../../main/event-bus.ts";
import {useHead} from "@vueuse/head";
import {VDateInput} from "vuetify/labs/components";


export default {
    components: {
        VDateInput, // Registering the component locally
    },
    setup() {
        useHead({
            title: 'Update Country',
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
        statuses: [
            {value: 1, text: 'Active'},
            {value: 0, text: 'Inactive'},
        ],
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
        async update() {
            this.resetErrors()
            if (this.checkValidation()) {
                axios.patch(`/countries/update/${this.id}`, this.formData).then((response) => {
                    showSuccessToast('country update successfully');
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
        async getItem() {
            axios.get(`/countries/list/${this.id}`, {}).then((response) => {
                this.item = response.data.data;
                this.formData = {
                    name: {
                        en: this.item.name.en,
                        ar: this.item.name.ar
                    },
                    region: {
                        en: this.item.region.en,
                        ar: this.item.region.ar
                    },
                    subregion: {
                        en: this.item.subregion.en,
                        ar: this.item.subregion.ar
                    },
                    iso3: this.item.iso3,
                    phone_code: this.item.phone_code,
                    status: Boolean(this.item.status),
                };

            }).catch((error) => {
                if (error?.response?.data?.message) {
                    showErrorToast(error.response.data.message)
                } else {
                    showErrorToast('Accurate error,please try again later')
                }
            });

        },


        checkValidation() {
            if (this.formData.password !== this.formData.password_confirmation) {
                this.errors.password_confirmation = "the password confirmation must be same password"
                return false;
            }
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
        this.getItem();
    }

}
</script>
