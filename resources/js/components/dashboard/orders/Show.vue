<template>
    <div class="col-xl-12">
        <div class="text-start my-4">
            <router-link to="/dash/orders" class="btn btn-secondary btn-b">
                <i class="las la-arrow-alt-circle-left"></i> Back to Orders
            </router-link>
        </div>

        <div v-if="loading" class="text-center py-5">
            <v-progress-circular indeterminate color="primary"></v-progress-circular>
        </div>

        <div v-else-if="order">
            <!-- Header + status -->
            <div class="card custom-card">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="mb-1">{{ order.order_number }}</h4>
                        <small class="text-muted">{{ $formatDate(order.created_at) }}</small>
                        <span class="badge ms-2" :class="statusClass(order.status)">{{ order.status_label }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label mb-0 me-2">Status</label>
                        <select v-model="statusToSave" class="form-control" style="width:auto">
                            <option v-for="s in STATUSES" :key="s.value" :value="s.value">{{ s.label }}</option>
                        </select>
                        <button class="btn btn-primary" :disabled="savingStatus" @click="saveStatus">
                            {{ savingStatus ? 'Saving...' : 'Update Status' }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Customer info box -->
                <div class="col-lg-6">
                    <div class="card custom-card">
                        <div class="card-header"><div class="card-title">Customer Details</div></div>
                        <div class="card-body">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr><th style="width:40%">Name</th><td>{{ order.customer_name }}</td></tr>
                                    <tr><th>Phone</th><td>{{ order.customer_phone }}</td></tr>
                                    <tr v-if="order.email"><th>Account Email</th><td>{{ order.email }}</td></tr>
                                    <tr><th>Governorate</th><td>{{ order.governorate_name }}</td></tr>
                                    <tr><th>Address</th><td>{{ order.address }}</td></tr>
                                    <tr v-if="order.notes"><th>Notes</th><td>{{ order.notes }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payment + summary -->
                <div class="col-lg-6">
                    <div class="card custom-card">
                        <div class="card-header"><div class="card-title">Payment & Summary</div></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <img v-if="order.payment_method_image" :src="order.payment_method_image" alt="" style="height:32px;width:32px;object-fit:contain">
                                <span class="fw-bold">{{ order.payment_method_name || '—' }}</span>
                            </div>
                            <div v-if="order.receipt_url" class="mb-3">
                                <a :href="order.receipt_url" target="_blank" class="btn btn-sm btn-info-light">
                                    <i class="fe fe-file-text me-1"></i> View transfer receipt
                                </a>
                            </div>
                            <p class="mb-1 d-flex justify-content-between"><span>Subtotal</span><span>{{ order.subtotal }} EGP</span></p>
                            <p class="mb-1 d-flex justify-content-between"><span>Shipping</span><span>{{ order.shipping_price }} EGP</span></p>
                            <p class="mb-0 d-flex justify-content-between fw-bold fs-5"><span>Total</span><span>{{ order.total }} EGP</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="card custom-card">
                <div class="card-header"><div class="card-title">Items</div></div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="it in order.items" :key="it.id">
                                <td>{{ it.product_name }}</td>
                                <td class="text-center">{{ it.product_price }}</td>
                                <td class="text-center">{{ it.quantity }}</td>
                                <td class="text-end">{{ it.line_total }}</td>
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
import { useRoute } from 'vue-router';
import axios from 'axios';
import { useHead } from '@vueuse/head';
import { ORDER_STATUSES, orderStatusClass } from './statuses';

useHead({ title: 'Order Details' });

const route = useRoute();
const STATUSES = ORDER_STATUSES;

const order = ref<any>(null);
const loading = ref(true);
const statusToSave = ref('pending');
const savingStatus = ref(false);

function statusClass(status: string) {
    return orderStatusClass(status);
}

async function fetchOrder() {
    loading.value = true;
    try {
        const response = await axios.get(`/orders/${route.params.id}`);
        order.value = response.data.data;
        statusToSave.value = order.value.status;
    } catch (error) {
        order.value = null;
    } finally {
        loading.value = false;
    }
}

async function saveStatus() {
    if (!order.value) return;
    savingStatus.value = true;
    try {
        const response = await axios.patch(`/orders/${order.value.id}/status`, { status: statusToSave.value });
        order.value = response.data.data;
        (window as any).showSuccessToast?.('Order status updated');
    } catch (error) {
        (window as any).showErrorToast?.('Failed to update status');
    } finally {
        savingStatus.value = false;
    }
}

onMounted(fetchOrder);
</script>
