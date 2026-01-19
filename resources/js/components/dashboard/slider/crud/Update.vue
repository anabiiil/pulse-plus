<template>
    <div class="text-start my-4">
        <router-link to="/dash/slider" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Update Slider
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="update" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Link</label>
                                        <input type="link"
                                               class="form-control"
                                               v-model="formData.link"/>
                                        <span class="text-danger" v-if="errors?.link">{{ errors?.url }}</span>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Image</label>
                                        <v-file-input clearable v-model="formData.image" accept="image/*"
                                                      density="compact"
                                                      variant="outlined"></v-file-input>
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
            title: 'Update Slider',
        });
    },
    props: {
        id: {
            required: true,
        },
    },
    data: () => ({
        errors: {},
        formData: {
            image: null,
            link: null,
        },
        item: null,
        errorList: '',
        loading: false,
    }),
    methods: {
        async update() {
            this.resetErrors()
            if (this.checkValidation()) {
                axios.post(`/slider/update/${this.id}`, this.formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }).then((response) => {
                    showSuccessToast('Slider updated successfully');
                    this.$router.push('/dash/slider');
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
                });
            }

        },
        async getItem() {
            axios.get(`/slider/list/${this.id}`, {}).then((response) => {
                this.item = response.data.data;
                this.formData = {
                    link: this.item?.link,
                }

            }).catch((error) => {
                if (error?.response?.data?.message) {
                    showErrorToast(error.response.data.message)
                } else {
                    showErrorToast('Accurate error,please try again later')
                }
            }).finally(() => {
                this.loading = false;
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
