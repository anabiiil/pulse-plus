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
                        <form class="container" @submit.prevent="handleSubmit" v-if="!loading">
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
                                        {{ loading ? 'Updating...' : 'Update' }}
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

import { ref, reactive, onMounted, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useNationalities } from '../../../../composables/useNationalities';

useHead({
    title: 'Update Nationality',
});

const router = useRouter();
const route = useRoute();
const { update, getNationality: fetchNationality, nationality } = useNationalities();

// Reactive state
const loading = ref(true);
const errors = reactive({});
const nationalityId = ref(route.params.id);

const formData = reactive({
    name: {
        en: '',
        ar: '',
    },
    status: true,
});

/**
 * Load nationality data on mount
 */
const loadNationality = async () => {
    try {
        loading.value = true;
        await fetchNationality(nationalityId.value);
        formData.name  = nationality.value.name;
        formData.status  = nationality.value.status === 1;
    } catch (error: any) {
        console.error('Failed to load nationality');
        await router.push('/dash/nationality');
    } finally {
        loading.value = false;
    }
};

/**
 * Watch nationality and update form data when it changes
 */
watch(
    () => nationality,
    (newNationality) => {
        if (newNationality) {
            formData.name.en = newNationality.name?.en || '';
            formData.name.ar = newNationality.name?.ar || '';
            formData.status = newNationality.status === 'active' || newNationality.status === true;
        }
    },
    { deep: true }
);

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
        await update(nationalityId.value, formData);
        await router.push('/dash/nationality');
    } catch (error: any) {
        // Handle 422 Unprocessable Entity (validation errors)
        if (error?.response?.status === 422) {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
        } else {
            // Handle other errors
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            const errorMsg = error?.response?.data?.message || 'Failed to update nationality';
            console.error(errorMsg);
        }
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    loadNationality();
});

</script>
