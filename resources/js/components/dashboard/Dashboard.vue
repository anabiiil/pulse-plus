<template>
    <!-- Revenue highlight (completed orders only) -->
    <div class="row">
        <div class="col-xxl-4 col-lg-6 col-md-6">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-top justify-content-between">
                        <div>
                            <span class="avatar avatar-md avatar-rounded bg-success">
                                <i class="ti ti-cash fs-16"></i>
                            </span>
                        </div>
                        <div class="flex-fill ms-3">
                            <p class="text-muted mb-0">Total Sales (Completed)</p>
                            <h4 class="fw-semibold mt-1">{{ money(stats.revenue.total_sales) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-lg-6 col-md-6">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-top justify-content-between">
                        <div>
                            <span class="avatar avatar-md avatar-rounded bg-warning">
                                <i class="ti ti-discount-2 fs-16"></i>
                            </span>
                        </div>
                        <div class="flex-fill ms-3">
                            <p class="text-muted mb-0">Total Discounts (Completed)</p>
                            <h4 class="fw-semibold mt-1">{{ money(stats.revenue.total_discount) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-lg-6 col-md-6">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-top justify-content-between">
                        <div>
                            <span class="avatar avatar-md avatar-rounded bg-primary">
                                <i class="ti ti-checklist fs-16"></i>
                            </span>
                        </div>
                        <div class="flex-fill ms-3">
                            <p class="text-muted mb-0">Completed Orders</p>
                            <h4 class="fw-semibold mt-1">{{ stats.revenue.completed_orders }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Entity counts -->
    <div class="row">
        <div class="col-xxl-2 col-lg-4 col-md-6" v-for="card in entityCards" :key="card.label">
            <div class="card custom-card overflow-hidden">
                <div class="card-body text-center">
                    <span class="avatar avatar-md avatar-rounded mb-2" :class="card.bg">
                        <i :class="card.icon" class="fs-16"></i>
                    </span>
                    <p class="text-muted mb-0">{{ card.label }}</p>
                    <h4 class="fw-semibold mt-1">{{ card.value }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders by status -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title">Orders by Status</div>
                    <span class="badge bg-light text-dark">Total: {{ stats.orders.total }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3" v-for="s in statusCards" :key="s.key">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge" :class="s.class">{{ s.label }}</span>
                                <span class="fw-semibold">{{ stats.orders.by_status[s.key] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useHead } from '@vueuse/head';

useHead({ title: 'Dashboard' });

interface Stats {
    users: number;
    products: number;
    services: number;
    sliders: number;
    payment_methods: number;
    coupons: number;
    orders: { total: number; by_status: Record<string, number> };
    revenue: { completed_orders: number; total_sales: number; total_discount: number };
}

const stats = ref<Stats>({
    users: 0,
    products: 0,
    services: 0,
    sliders: 0,
    payment_methods: 0,
    coupons: 0,
    orders: { total: 0, by_status: {} },
    revenue: { completed_orders: 0, total_sales: 0, total_discount: 0 },
});

const money = (v: number | undefined) => Number(v ?? 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

const entityCards = computed(() => [
    { label: 'Users', value: stats.value.users, icon: 'ti ti-users', bg: 'bg-primary' },
    { label: 'Products', value: stats.value.products, icon: 'ti ti-package', bg: 'bg-success' },
    { label: 'Services', value: stats.value.services, icon: 'ti ti-briefcase', bg: 'bg-secondary' },
    { label: 'Sliders', value: stats.value.sliders, icon: 'ti ti-photo', bg: 'bg-info' },
    { label: 'Payment Methods', value: stats.value.payment_methods, icon: 'ti ti-credit-card', bg: 'bg-warning' },
    { label: 'Coupons', value: stats.value.coupons, icon: 'ti ti-discount', bg: 'bg-danger' },
]);

const statusCards = [
    { key: 'pending', label: 'Pending', class: 'bg-warning' },
    { key: 'confirmed', label: 'Confirmed', class: 'bg-info' },
    { key: 'in_progress', label: 'In Progress', class: 'bg-primary' },
    { key: 'on_way', label: 'On Way', class: 'bg-purple' },
    { key: 'completed', label: 'Completed', class: 'bg-success' },
    { key: 'canceled', label: 'Canceled', class: 'bg-danger' },
    { key: 'canceled_by_client', label: 'Canceled by Client', class: 'bg-danger' },
];

const fetchStats = async () => {
    try {
        const response = await axios.get('/dashboard/statistics');
        stats.value = { ...stats.value, ...response.data.data };
    } catch (error) {
        console.error('Failed to load dashboard statistics', error);
    }
};

onMounted(() => {
    fetchStats();
});
</script>

<style scoped>
.card {
    margin-bottom: 1rem;
}
</style>
