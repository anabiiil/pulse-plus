<template>
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Orders
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Search</label>
                            <input type="search" v-model="searchQuery" class="form-control" placeholder="Order # / name / phone">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select v-model="statusFilter" class="form-control">
                                <option value="">All</option>
                                <option v-for="s in STATUSES" :key="s.value" :value="s.value">{{ s.label }}</option>
                            </select>
                        </div>
                    </div>

                    <v-data-table-server
                        v-model:items-per-page="itemsPerPage"
                        :headers="headers"
                        :items="orders"
                        :items-length="totalCount"
                        :loading="loading"
                        :items-per-page-options="[50,100,200,500,-1]"
                        @update:options="handleOptions"
                    >
                        <template #item.total="{ item }">
                            {{ item.total }} EGP
                        </template>
                        <template #item.payment_method_name="{ item }">
                            <span class="d-inline-flex align-items-center gap-2">
                                <img v-if="item.payment_method_image" :src="item.payment_method_image" alt="" style="height:22px;width:22px;object-fit:contain">
                                {{ item.payment_method_name || '—' }}
                            </span>
                        </template>
                        <template #item.status="{ item }">
                            <span class="badge" :class="statusClass(item.status)">{{ item.status_label }}</span>
                        </template>
                        <template #item.created_at="{ item }">
                            {{ $formatDate(item.created_at) }}
                        </template>
                        <template #item.actions="{ item }">
                            <router-link :to="`/dash/orders/${item.id}`" class="btn btn-sm btn-info-light">
                                <i class="fe fe-eye me-1"></i> View
                            </router-link>
                        </template>
                    </v-data-table-server>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import axios from 'axios';
import { useHead } from '@vueuse/head';
import { ORDER_STATUSES, orderStatusClass } from './statuses';

useHead({ title: 'Orders' });

const STATUSES = ORDER_STATUSES;

const headers = [
    { key: 'order_number', title: 'Order #', sortable: false },
    { key: 'customer_name', title: 'Customer', sortable: false },
    { key: 'governorate_name', title: 'Governorate', sortable: false },
    { key: 'payment_method_name', title: 'Payment', sortable: false },
    { key: 'total', title: 'Total', sortable: true },
    { key: 'status', title: 'Status', sortable: true },
    { key: 'created_at', title: 'Date', sortable: true },
    { key: 'actions', title: 'Actions', sortable: false },
];

const orders = ref<any[]>([]);
const totalCount = ref(0);
const loading = ref(false);
const itemsPerPage = ref(50);
const page = ref(1);
const sortBy = ref('id');
const sortDesc = ref('desc');
const searchQuery = ref('');
const statusFilter = ref('');

function statusClass(status: string) {
    return orderStatusClass(status);
}

async function fetchOrders() {
    loading.value = true;
    try {
        const response = await axios.get('/orders', {
            params: {
                page: page.value,
                per_page: itemsPerPage.value,
                sortBy: sortBy.value,
                sortDesc: sortDesc.value,
                search: searchQuery.value,
                status: statusFilter.value,
            },
        });
        orders.value = response.data.data || [];
        totalCount.value = response.data.pagination?.meta?.page?.total || 0;
    } catch (error) {
        orders.value = [];
    } finally {
        loading.value = false;
    }
}

function handleOptions(options: any) {
    page.value = options.page || 1;
    itemsPerPage.value = options.itemsPerPage || 50;
    if (options.sortBy?.length > 0) {
        sortBy.value = options.sortBy[0].key;
        sortDesc.value = options.sortBy[0].order;
    }
    fetchOrders();
}

watch([searchQuery, statusFilter], () => {
    page.value = 1;
    fetchOrders();
});
</script>
