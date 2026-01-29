<template>
    <div class="text-start my-4">
        <router-link to="/dash/users" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
    </div>

    <div class="col-xl-12" v-if="!loading && user">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    User Information - {{ user?.name }}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-12">
                        <h5 class="mb-3">Basic Information</h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Name:</label>
                            <p class="fw-bold">{{ user.name }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Email:</label>
                            <p class="fw-bold">{{ user.email }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Phone:</label>
                            <p class="fw-bold">{{ user.phone || '-' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Gender:</label>
                            <p class="fw-bold text-capitalize">{{ user.gender || '-' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Birth Date:</label>
                            <p class="fw-bold">{{ user.birthdate ? formatDate(user.birthdate) : '-' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Marital Status:</label>
                            <p class="fw-bold">{{ user.marital_status || '-' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Country:</label>
                            <p class="fw-bold">{{ user.country?.name || '-' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Status:</label>
                            <p>
                                <span class="badge" :class="StatusEnum.getClass(user.status)">
                                    {{ StatusEnum.getLabel(user.status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Address:</label>
                            <p class="fw-bold">{{ user.address || '-' }}</p>
                        </div>
                    </div>

                    <!-- QR Code Section -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3">QR Code</h5>
                    </div>

                    <div class="col-md-6 mb-3" v-if="user.qr_code_path">
                        <div class="info-item">
                            <img :src="user.qr_code_path" alt="QR Code" style="max-width: 200px;">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Hash URL:</label>
                            <p class="fw-bold" style="word-break: break-all;">{{ user.hash_url || '-' }}</p>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3">Account Details</h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Created At:</label>
                            <p class="fw-bold">{{ formatDate(user.created_at) }}</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">Updated At:</label>
                            <p class="fw-bold">{{ formatDate(user.updated_at) }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="col-md-12 text-center mt-4">
                        <router-link :to="`/dash/users/${user.id}/edit`" class="btn btn-primary me-2">
                            <i class="fe fe-edit"></i> Edit User
                        </router-link>
                        <router-link :to="`/dash/users/${user.id}/delete`" class="btn btn-danger">
                            <i class="fe fe-trash"></i> Delete User
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-else-if="loading" class="text-center py-4">
        <v-progress-circular indeterminate color="primary"></v-progress-circular>
    </div>
</template>

<script setup lang="ts">

import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useUsers } from '../../../../composables/useUsers';
import { formatDate } from '../../../../main/date';
import { StatusEnum } from '../../../../enums/StatusEnum';

declare global {
    interface Window {
        showErrorToast: (message: string) => void;
    }
}

useHead({
    title: 'User Details',
});

const router = useRouter();
const route = useRoute();
const { getUser, user } = useUsers();

const loading = ref(true);
const userId = ref<string | number>(Array.isArray(route.params.id) ? route.params.id[0] : route.params.id);

const loadUser = async () => {
    try {
        loading.value = true;
        await getUser(userId.value);

        if (!user.value) {
            window.showErrorToast('User not found');
            await router.push('/dash/users');
        }
    } catch (error: any) {
        const errorMsg = error?.response?.data?.message || 'Failed to load user';
        window.showErrorToast(errorMsg);
        await router.push('/dash/users');
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    loadUser();
});

</script>

<style scoped>
.info-item {
    padding: 0.5rem 0;
}

.info-item label {
    display: block;
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
}

.info-item p {
    margin: 0;
    font-size: 1rem;
}

.card-body {
    padding: 2rem;
}

h5 {
    color: #495057;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
}
</style>
