<template>
    <div class="text-start my-4">
        <router-link to="/dash/coupons" class="btn btn-secondary me-2 btn-b">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </router-link>
        <router-link :to="`/dash/coupons/${couponId}/edit`" class="btn btn-primary me-2 btn-b">
            <i class="fe fe-edit"></i>
            Edit
        </router-link>
    </div>

    <!-- Coupon header -->
    <div class="col-xl-12" v-if="coupon">
        <div class="card custom-card">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <h4 class="fw-semibold mb-1">{{ coupon.code }}</h4>
                    <p class="text-muted mb-0" v-if="coupon.name">{{ coupon.name }}</p>
                    <p class="text-muted mb-0 mt-1 small">
                        <i class="ti ti-calendar me-1"></i>
                        {{ coupon.starts_at || '—' }} &rarr; {{ coupon.expires_at || '—' }}
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge" :class="CouponTypeEnum.getClass(coupon.type)">
                        {{ CouponTypeEnum.getLabel(coupon.type) }}
                    </span>
                    <span class="badge bg-light text-dark">
                        {{ CouponTypeEnum.isPercentage(coupon.type) ? Number(coupon.value) + '%' : Number(coupon.value).toFixed(2) }}
                    </span>
                    <span class="badge" :class="coupon.is_redeemable ? 'bg-success' : 'bg-danger'">
                        {{ coupon.is_redeemable ? 'Redeemable' : 'Not Redeemable' }}
                    </span>
                    <span class="badge" :class="StatusEnum.getClass(coupon.status)">
                        {{ StatusEnum.getLabel(coupon.status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics cards (completed orders only) -->
    <div class="row">
        <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <span class="avatar avatar-md avatar-rounded bg-primary mb-2">
                        <i class="ti ti-shopping-cart fs-16"></i>
                    </span>
                    <p class="text-muted mb-0">Completed Orders</p>
                    <h4 class="fw-semibold mt-1">{{ statistics?.orders_count ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <span class="avatar avatar-md avatar-rounded bg-success mb-2">
                        <i class="ti ti-package fs-16"></i>
                    </span>
                    <p class="text-muted mb-0">Pieces Sold</p>
                    <h4 class="fw-semibold mt-1">{{ statistics?.items_count ?? 0 }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <span class="avatar avatar-md avatar-rounded bg-warning mb-2">
                        <i class="ti ti-discount-2 fs-16"></i>
                    </span>
                    <p class="text-muted mb-0">Total Discount</p>
                    <h4 class="fw-semibold mt-1">{{ Number(statistics?.total_discount ?? 0).toFixed(2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <span class="avatar avatar-md avatar-rounded bg-info mb-2">
                        <i class="ti ti-cash fs-16"></i>
                    </span>
                    <p class="text-muted mb-0">Total Sales</p>
                    <h4 class="fw-semibold mt-1">{{ Number(statistics?.total_sales ?? 0).toFixed(2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders breakdown by status (all orders on this coupon) -->
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">Orders Breakdown</div>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">Click a card to filter the orders below.</p>
                <div class="row g-3">
                    <div class="col-xxl col-lg-3 col-md-4 col-6" v-for="card in breakdownCards" :key="card.label">
                        <div
                            class="border rounded-3 p-3 h-100 d-flex flex-column align-items-center text-center breakdown-card"
                            :class="{ 'border-primary shadow-sm active': card.filter === selectedFilter }"
                            role="button"
                            @click="selectFilter(card.filter)"
                        >
                            <span class="badge mb-2" :class="card.class">{{ card.label }}</span>
                            <h4 class="fw-semibold mb-0">{{ card.value }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders list (filtered by the selected status card) -->
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title text-capitalize">
                    {{ selectedLabel }} Orders
                </div>
                <button v-if="selectedFilter" type="button" class="btn btn-sm btn-light" @click="selectFilter(null)">
                    <i class="fe fe-x me-1"></i> Clear filter
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <v-data-table-server
                        :key="selectedFilter || 'all'"
                        v-model:items-per-page="itemsPerPage"
                        :headers="headers"
                        :items="orders"
                        :items-length="ordersMeta?.total || 0"
                        :loading="loading"
                        :items-per-page-options="[50,100, 200, 300, 500, -1]"
                        @update:options="onOptions"
                    >
                        <template #item.order_number="{ item }">
                            <router-link :to="`/dash/orders/${item.id}`" class="text-primary">
                                {{ item.order_number }}
                            </router-link>
                        </template>
                        <template #item.status="{ item }">
                            <span class="badge" :class="orderStatusClass(item.status)">{{ item.status_label }}</span>
                        </template>
                        <template #item.items_count="{ item }">
                            {{ item.items_count ?? 0 }}
                        </template>
                        <template #item.discount="{ item }">
                            {{ Number(item.discount ?? 0).toFixed(2) }}
                        </template>
                        <template #item.total="{ item }">
                            {{ Number(item.total ?? 0).toFixed(2) }}
                        </template>
                        <template #item.created_at="{ item }">
                            {{ $formatDate(item.created_at) }}
                        </template>
                    </v-data-table-server>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useHead } from '@vueuse/head';
import { StatusEnum } from '../../../enums/StatusEnum';
import { CouponTypeEnum } from '../../../enums/CouponTypeEnum';
import { orderStatusClass } from '../orders/statuses';
import { useCoupons } from '../../../composables/useCoupons';

useHead({ title: 'Coupon Statistics' });

const route = useRoute();
const couponId = ref(Number(route.params.id));

const { getCoupon, getCouponOrders, coupon, statistics, orders, ordersMeta, loading } = useCoupons();

const itemsPerPage = ref(50);
const selectedFilter = ref<string | null>(null);

// Order-count cards grouped by status (all orders that used this coupon).
// `filter` is the status query sent to the orders endpoint (null = all).
const breakdownCards = computed(() => {
    const byStatus = statistics.value?.orders_by_status || {};
    const get = (key: string) => Number(byStatus[key] || 0);

    return [
        { label: 'All Orders', value: Number(statistics.value?.total_orders || 0), class: 'bg-dark', filter: null },
        { label: 'Delivered', value: get('completed'), class: 'bg-success', filter: 'completed' },
        { label: 'Pending', value: get('pending'), class: 'bg-warning', filter: 'pending' },
        { label: 'Confirmed', value: get('confirmed'), class: 'bg-info', filter: 'confirmed' },
        { label: 'In Progress', value: get('in_progress'), class: 'bg-primary', filter: 'in_progress' },
        { label: 'On Way', value: get('on_way'), class: 'bg-purple', filter: 'on_way' },
        { label: 'Not Delivered / Rejected', value: get('canceled') + get('canceled_by_client'), class: 'bg-danger', filter: 'canceled,canceled_by_client' },
    ];
});

const selectedLabel = computed(() =>
    breakdownCards.value.find((c) => c.filter === selectedFilter.value)?.label ?? 'All'
);

const selectFilter = (filter: string | null) => {
    selectedFilter.value = filter;
};

const headers = [
    { align: 'start', key: 'order_number', title: 'Order #', sortable: false },
    { key: 'customer_name', title: 'Customer', sortable: false },
    { key: 'status', title: 'Status', sortable: false },
    { key: 'items_count', title: 'Pieces', sortable: false },
    { key: 'discount', title: 'Discount', sortable: false },
    { key: 'total', title: 'Total', sortable: false },
    { key: 'created_at', title: 'Date', sortable: false },
];

const onOptions = (options: any) => {
    itemsPerPage.value = options.itemsPerPage || 50;
    getCouponOrders(couponId.value, {
        page: options.page || 1,
        per_page: itemsPerPage.value,
        ...(selectedFilter.value ? { status: selectedFilter.value } : {}),
    });
};

onMounted(() => {
    getCoupon(couponId.value);
});
</script>

<style scoped>
.breakdown-card {
    cursor: pointer;
    transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
}

.breakdown-card:hover {
    transform: translateY(-2px);
    border-color: var(--bs-primary);
}

.breakdown-card.active {
    background-color: rgba(var(--bs-primary-rgb), 0.06);
}
</style>
