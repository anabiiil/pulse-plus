<template>
    <div class="text-start my-4">
        <router-link to="/dash/users" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Create User
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <form class="container" @submit.prevent="handleSubmit">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['name'] }"
                                            v-model="formData.name"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['name']">
                                            {{ Array.isArray(errors['name']) ? errors['name'][0] : errors['name'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input
                                            type="email"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['email'] }"
                                            v-model="formData.email"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['email']">
                                            {{ Array.isArray(errors['email']) ? errors['email'][0] : errors['email'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <input
                                            type="password"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['password'] }"
                                            v-model="formData.password"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['password']">
                                            {{ Array.isArray(errors['password']) ? errors['password'][0] : errors['password'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Phone</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['phone'] }"
                                            v-model="formData.phone"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['phone']">
                                            {{ Array.isArray(errors['phone']) ? errors['phone'][0] : errors['phone'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Birth Date</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['birthdate'] }"
                                            v-model="formData.birthdate"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['birthdate']">
                                            {{ Array.isArray(errors['birthdate']) ? errors['birthdate'][0] : errors['birthdate'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Gender</label>
                                        <select
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['gender'] }"
                                            v-model="formData.gender"
                                        >
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <span class="text-danger d-block mt-2" v-if="errors['gender']">
                                            {{ Array.isArray(errors['gender']) ? errors['gender'][0] : errors['gender'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Marital Status</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['marital_status'] }"
                                            v-model="formData.marital_status"
                                        >
                                        <span class="text-danger d-block mt-2" v-if="errors['marital_status']">
                                            {{ Array.isArray(errors['marital_status']) ? errors['marital_status'][0] : errors['marital_status'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Country</label>
                                        <select
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['country_id'] }"
                                            v-model="formData.country_id"
                                        >
                                            <option value="">Select Country</option>
                                            <option v-for="country in countries" :key="country.id" :value="country.id">
                                                {{ country.name }}
                                            </option>
                                        </select>
                                        <span class="text-danger d-block mt-2" v-if="errors['country_id']">
                                            {{ Array.isArray(errors['country_id']) ? errors['country_id'][0] : errors['country_id'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea
                                            class="form-control"
                                            :class="{ 'is-invalid': errors['address'] }"
                                            v-model="formData.address"
                                            rows="3"
                                        ></textarea>
                                        <span class="text-danger d-block mt-2" v-if="errors['address']">
                                            {{ Array.isArray(errors['address']) ? errors['address'][0] : errors['address'] }}
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

import { ref, reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useUsers } from '../../../../composables/useUsers';
import axios from 'axios';

declare global {
    interface Window {
        showErrorToast: (message: string) => void;
        showSuccessToast: (message: string) => void;
    }
}

useHead({
    title: 'Create User',
});

const router = useRouter();
const { create } = useUsers();

// Reactive state
const loading = ref(false);
const errors = reactive<Record<string, any>>({});
const countries = ref<Array<{id: number, name: string}>>([]);

const formData = reactive({
    name: '',
    email: '',
    password: '',
    phone: '',
    birthdate: '',
    gender: '',
    marital_status: '',
    country_id: '',
    address: '',
    status: true,
});

/**
 * Load countries
 */
const loadCountries = async () => {
    try {
        const response = await axios.get('/countries');
        countries.value = response.data.data || [];
    } catch (error) {
        console.error('Failed to load countries:', error);
    }
};

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
        const data = {
            name: formData.name,
            email: formData.email,
            password: formData.password,
            phone: formData.phone || undefined,
            birthdate: formData.birthdate || undefined,
            gender: formData.gender || undefined,
            marital_status: formData.marital_status || undefined,
            country_id: formData.country_id || undefined,
            address: formData.address || undefined,
            status: formData.status ? '1' : '0',
        };

        await create(data);
        await router.push('/dash/users');
    } catch (error: any) {
        if (error?.response?.status === 422) {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            window.showErrorToast(error?.response?.data?.message || 'Validation error occurred');
        } else {
            const apiErrors = error?.response?.data?.errors || {};
            Object.assign(errors, apiErrors);
            const errorMsg = error?.response?.data?.message || 'Failed to create user';
            window.showErrorToast(errorMsg);
        }
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    loadCountries();
});

</script>
