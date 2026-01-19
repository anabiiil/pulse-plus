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
                    Create slider
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="store" enctype="multipart/form-data">
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
            title: 'Create Slider',
        });
    },
    data: () => ({
        errors: {},
        formData: {
            image: null,
            link: null,
        },
    }),

    methods: {
        async store() {

            this.resetErrors()

            if (this.checkValidation()) {
                axios.post('slider/create', this.formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                }).then((response) => {
                    showSuccessToast('Slider created successfully');
                    this.$router.push('/dash/slider');

                }).catch((error) => {
                    this.errors = error?.response?.data?.errors;
                    // if (error.response && error.response.data) {
                    //     this.errors = error.response.data.errors; // Assuming your Laravel backend returns validation errors under `errors`
                    // } else {
                    //     console.error('Error creating admin:', error);
                    // }
                }).finally(() => {
                    this.loading = false;
                });
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
        }
    },

}
</script>
<style scoped>
.v-text-field.v-text-field--solo .v-input__control {
    height: 10px;
}

</style>
