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
                    Delete slider
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="destroy">
                            <div class="row">
                                <div class="col-12 my-4">
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <svg class="flex-shrink-0 me-2 svg-danger" xmlns="http://www.w3.org/2000/svg"
                                             enable-background="new 0 0 24 24" height="1.5rem" viewBox="0 0 24 24"
                                             width="1.5rem" fill="#000000">
                                            <g>
                                                <rect fill="none" height="24" width="24"></rect>
                                            </g>
                                            <g>
                                                <g>
                                                    <g>
                                                        <path
                                                            d="M15.73,3H8.27L3,8.27v7.46L8.27,21h7.46L21,15.73V8.27L15.73,3z M19,14.9L14.9,19H9.1L5,14.9V9.1L9.1,5h5.8L19,9.1V14.9z"></path>
                                                        <rect height="6" width="2" x="11" y="7"></rect>
                                                        <rect height="2" width="2" x="11" y="15"></rect>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <div>
                                            Are you sure delete ({{ item?.title?.en  || item?.desc?.en }})?
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center my-4">
                                    <button type="submit" class="btn btn-danger">Delete</button>
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
            title: 'Delete Slider',
        });
    },
    props: {
        id: {
            required: true,
        },
    },

    data: () => ({
        errors: {},
        item: null,
        loading: false,
    }),
    mounted() {
        this.getItem();
    },
    methods: {
        async destroy() {
            this.resetErrors()
            if (this.checkValidation()) {
                axios.delete(`slider/delete/${this.id}`, this.formData).then((response) => {
                    // response.data.data.code
                    showSuccessToast('Slider deleted successfully');
                    this.$router.push('/dash/slider');
                }).catch((error) => {
                    if (error?.response?.data?.message) {
                        showErrorToast(error.response.data.message)
                    } else {
                        showErrorToast('Accurate error,please try again later')
                    }
                });


            }else{
                showErrorToast('Slider not found')
            }

        },

        async getItem() {
            axios.get(`/slider/list/${this.id}`, {}).then((response) => {
                this.item = response.data.data;
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
            return this.item;

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
