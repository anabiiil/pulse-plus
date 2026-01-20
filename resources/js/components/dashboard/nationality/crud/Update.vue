<template>
    <div class="text-start my-4">
        <router-link to="/dash/nationality" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Update Nationality ({{ formData?.name?.en }})
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


import {useHead} from "@vueuse/head";
import {VDateInput} from "vuetify/labs/components";


export default {
    components: {
        VDateInput, // Registering the component locally
    },
    setup() {
        useHead({
            title: 'Update Nationality',
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
                    showSuccessToast('Nationality updated successfully');
                    this.$router.push('/dash/nationality');
                }).catch((error) => {
                    this.errors = error?.response?.data?.errors;
                    if (error?.response?.data?.message) {
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
