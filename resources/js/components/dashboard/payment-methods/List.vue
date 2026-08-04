<template>
    <div class="col-xl-12">
        <div class="text-end my-4">
            <router-link to="/dash/payment-methods/create" class="btn btn-info me-2 btn-b">
                Add Payment Method
            </router-link>
        </div>
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">Payment Methods</div>
            </div>
            <div class="card-body">
                <div v-if="loading" class="text-center py-5">
                    <v-progress-circular indeterminate color="primary"></v-progress-circular>
                </div>
                <div v-else class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead>
                            <tr>
                                <th style="width:80px">Image</th>
                                <th>Name (EN)</th>
                                <th>Name (AR)</th>
                                <th>Type</th>
                                <th>Active</th>
                                <th style="width:150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="method in methods" :key="method.id">
                                <td>
                                    <img v-if="method.image_url" :src="method.image_url" alt="" style="height:36px;width:36px;object-fit:contain">
                                    <span v-else class="text-muted">—</span>
                                </td>
                                <td>{{ method.name_en }}</td>
                                <td>{{ method.name_ar }}</td>
                                <td>
                                    <span class="badge" :class="method.is_system ? 'bg-secondary' : 'bg-primary-transparent'">
                                        {{ method.is_system ? 'System' : 'Custom' }}
                                    </span>
                                </td>
                                <td>
                                    <v-switch
                                        :model-value="method.is_active"
                                        density="compact"
                                        hide-details
                                        :color="method.is_active ? 'success' : ''"
                                        @update:model-value="toggleActive(method, $event)"
                                    ></v-switch>
                                </td>
                                <td>
                                    <router-link :to="`/dash/payment-methods/${method.id}/edit`" class="btn btn-sm btn-primary-light me-1">
                                        <i class="fe fe-edit"></i>
                                    </router-link>
                                    <button
                                        v-if="!method.is_system"
                                        class="btn btn-sm btn-danger-light"
                                        @click="remove(method)"
                                    >
                                        <i class="fe fe-trash"></i>
                                    </button>
                                    <span v-else class="text-muted small" title="System methods can't be deleted">
                                        <i class="fe fe-lock"></i>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useHead } from '@vueuse/head';

useHead({ title: 'Payment Methods' });

const methods = ref<any[]>([]);
const loading = ref(true);

async function fetchMethods() {
    loading.value = true;
    try {
        const response = await axios.get('/payment-methods');
        methods.value = response.data.data || [];
    } catch (error) {
        methods.value = [];
    } finally {
        loading.value = false;
    }
}

async function toggleActive(method: any, value: boolean) {
    try {
        await axios.patch(`/payment-methods/${method.id}`, { is_active: value ? 1 : 0 });
        method.is_active = value;
        (window as any).showSuccessToast?.('Updated');
    } catch (error) {
        (window as any).showErrorToast?.('Failed to update');
    }
}

async function remove(method: any) {
    if (!confirm(`Delete "${method.name_en}"?`)) return;
    try {
        await axios.delete(`/payment-methods/${method.id}`);
        methods.value = methods.value.filter((m) => m.id !== method.id);
        (window as any).showSuccessToast?.('Deleted');
    } catch (error: any) {
        (window as any).showErrorToast?.(error?.response?.data?.message || 'Failed to delete');
    }
}

onMounted(fetchMethods);
</script>
