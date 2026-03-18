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
                            <label class="text-muted">Assigned Item:</label>
                            <p class="fw-bold">{{ user.item?.name || user.item?.uuid || '-' }}</p>
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

                    <div class="col-md-6 mb-3" v-if="user.item?.uuid">
                        <div class="info-item">
                            <label class="text-muted">Item QR Code:</label>
                            <div class="mt-2">
                                <canvas ref="qrCanvas" style="max-width: 200px; height: 200px;" class="mb-2"></canvas>
                                <div>
                                    <button @click="downloadQRCode" class="btn btn-sm btn-primary">
                                        <i class="fe fe-download"></i> Download QR Code
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3" v-else>
                        <div class="info-item">
                            <label class="text-muted">Item QR Code:</label>
                            <p class="text-muted fst-italic">No item assigned to this user.</p>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="info-item">
                            <label class="text-muted">User Link (Item UUID):</label>
                            <div class="d-flex align-items-center gap-2 mt-2" v-if="user.item?.uuid">
                                <input
                                    type="text"
                                    :value="getUserLink()"
                                    readonly
                                    class="form-control form-control-sm"
                                    id="userLinkInput"
                                    style="font-size: 0.875rem;"
                                >
                                <button
                                    @click="copyUserLink"
                                    class="btn btn-sm btn-info"
                                    :class="{ 'btn-success': copied }"
                                >
                                    <i :class="copied ? 'fe fe-check' : 'fe fe-copy'"></i>
                                    {{ copied ? 'Copied!' : 'Copy' }}
                                </button>
                            </div>
                            <p class="text-muted fst-italic mt-2" v-else>No item assigned.</p>
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

import { ref, onMounted, nextTick, watch } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { useUsers } from '../../../../composables/useUsers';
import { formatDate } from '../../../../main/date';
import { StatusEnum } from '../../../../enums/StatusEnum';
import QRCode from 'qrcode';

declare global {
    interface Window {
        showErrorToast: (message: string) => void;
        showSuccessToast: (message: string) => void;
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
const copied = ref(false);
const qrCanvas = ref<HTMLCanvasElement | null>(null);

/**
 * Get the user link using item UUID
 */
const getUserLink = (): string => {
    if (!user.value?.item?.uuid) return '';
    return `https://pulse-plus.com/user/info/${user.value.item.uuid}`;
};

/**
 * Generate QR code on the canvas from item UUID
 */
const generateQRCode = async (): Promise<void> => {
    await nextTick();
    if (qrCanvas.value && user.value?.item?.uuid) {
        await QRCode.toCanvas(qrCanvas.value, user.value.item.uuid, {
            width: 200,
            margin: 2,
            color: { dark: '#000000', light: '#ffffff' },
        });
    }
};

/**
 * Download the QR code as PNG
 */
const downloadQRCode = (): void => {
    if (!qrCanvas.value || !user.value?.item) {
        if (window.showErrorToast) {
            window.showErrorToast('QR Code not available');
        }
        return;
    }
    const link = document.createElement('a');
    link.download = `item-qr-${user.value.item.uuid}.png`;
    link.href = qrCanvas.value.toDataURL('image/png');
    link.click();

    if (window.showSuccessToast) {
        window.showSuccessToast('QR Code downloaded successfully!');
    }
};

/**
 * Copy user link to clipboard
 */
const copyUserLink = async (): Promise<void> => {
    try {
        const link = getUserLink();
        await navigator.clipboard.writeText(link);
        copied.value = true;

        if (window.showSuccessToast) {
            window.showSuccessToast('Link copied to clipboard!');
        }

        setTimeout(() => {
            copied.value = false;
        }, 2000);
    } catch (error) {
        console.error('Failed to copy:', error);
        if (window.showErrorToast) {
            window.showErrorToast('Failed to copy link');
        }
    }
};

const loadUser = async (): Promise<void> => {
    try {
        loading.value = true;
        await getUser(Number(userId.value));

        if (!user.value) {
            window.showErrorToast('User not found');
            await router.push('/dash/users');
            return;
        }

        await generateQRCode();
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

.gap-2 {
    gap: 0.5rem;
}

.btn {
    transition: all 0.3s ease;
}

.btn-success {
    animation: pulse 0.5s ease;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}
</style>
