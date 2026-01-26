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
                    Create Nationality
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="handleSubmit">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name En</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['name.en'] }"
                                            v-model="formData.name.en"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['name.en']">
                                            {{ Array.isArray(errors['name.en']) ? errors['name.en'][0] : errors['name.en'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name Ar</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['name.ar'] }"
                                            v-model="formData.name.ar"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['name.ar']">
                                            {{ Array.isArray(errors['name.ar']) ? errors['name.ar'][0] : errors['name.ar'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Status</label>
                                        <v-switch
                                            v-model="formData.status"
                                            density="compact"
                                            :color="formData.status ? 'success' : ''"
                                            label=""
                                        ></v-switch>
                                        <span class="text-danger d-block mt-2" v-if="errors['status']">
                                            {{ Array.isArray(errors['status']) ? errors['status'][0] : errors['status'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center my-4">
                                    <button
                                        type="submit"
                                        class="btn btn-success"
                                        :disabled="loading"
                                    >
                                        {{ loading ? 'Creating...' : 'Create' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>
<script setup lang="ts">

import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useNationalities } from '../../../../composables/useNationalities';

useHead({
    title: 'Create Nationality',
});

const router = useRouter();
const { create } = useNationalities();

// Reactive state
const loading = ref(false);
const errors = reactive({});

const formData = reactive({
    name: {
        en: '',
        ar: '',
    },
    status: true,
});

/**
 * Reset form errors
 */
const resetErrors = () => {
    Object.keys(errors).forEach(key => {
        delete errors[key];
    });
};

/**
 * Handle form submission
 */
const handleSubmit = async () => {
    resetErrors();
    loading.value = true;

    try {
        await create(formData);
        // Success - redirect to list
        await router.push('/dash/nationality');
    } catch (error) {
        // Handle 422 Unprocessable Entity (validation errors)
        if (error?.response?.status === 422) {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
        } else {
            // Handle other errors
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            const errorMsg = error?.response?.data?.message || 'Failed to create nationality';
            console.error(errorMsg);
        }
    } finally {
        loading.value = false;
    }
};

</script>
