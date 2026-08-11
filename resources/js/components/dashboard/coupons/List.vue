<template>
    <div class="col-xl-12">
        <div class="text-end my-4">
            <router-link to="/dash/coupons/create" class="btn btn-info me-2 btn-b">
                Create Coupon
            </router-link>
        </div>
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Coupons
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="search_filter mb-4">
                        <div class="row">
                            <div class="col-md-4 d-flex">
                                <div class="search-input mb-4">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="search" v-model="searchQuery" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <div class="row">
                            <div class="col-sm-12">
                                <v-data-table-server
                                    v-model:items-per-page="itemsPerPage"
                                    :headers="headers"
                                    :items="coupons"
                                    :items-length="totalCount"
                                    :loading="loading"
                                    :search="searchQuery"
                                    item-value="code"
                                    :items-per-page-options="[50,100, 200, 300, 500, -1]"
                                    @update:options="handleTableOptionsChange"
                                >
                                    <template #item.code="{ item }">
                                        <router-link :to="`/dash/coupons/${item.id}`" class="text-primary fw-semibold">
                                            {{ item.code }}
                                        </router-link>
                                    </template>

                                    <template #item.type="{ item }">
                                        <span class="badge" :class="CouponTypeEnum.getClass(item.type)">
                                            {{ CouponTypeEnum.getLabel(item.type) }}
                                        </span>
                                    </template>

                                    <template #item.value="{ item }">
                                        <span v-if="CouponTypeEnum.isPercentage(item.type)">{{ Number(item.value) }}%</span>
                                        <span v-else>{{ Number(item.value).toFixed(2) }}</span>
                                    </template>

                                    <template #item.validity="{ item }">
                                        <span class="text-muted small">{{ item.starts_at || '—' }} → {{ item.expires_at || '—' }}</span>
                                    </template>

                                    <template #item.orders_count="{ item }">
                                        {{ item.orders_count ?? 0 }}
                                    </template>

                                    <template #item.status="{ item }">
                                        <span class="badge" :class="StatusEnum.getClass(item.status)">
                                            {{ StatusEnum.getLabel(item.status) }}
                                        </span>
                                    </template>

                                    <template #item.created_at="{ item }">
                                        {{ $formatDate(item.created_at) }}
                                    </template>

                                    <template #item.actions="{ item }">
                                        <v-menu>
                                            <template v-slot:activator="{ props }">
                                                <v-btn icon="mdi-dots-vertical" variant="text" v-bind="props"></v-btn>
                                            </template>

                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link :to="`/dash/coupons/${item.id}`" class="text-info">
                                                            <i title="view" class="fe fe-bar-chart-2 me-2"></i> Stats
                                                        </router-link>
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link :to="`/dash/coupons/${item.id}/edit`" class="text-primary">
                                                            <i title="edit" class="fe fe-edit me-2"></i> Edit
                                                        </router-link>
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link :to="`/dash/coupons/${item.id}/delete`" class="text-danger">
                                                            <i title="delete" class="fe fe-trash me-2"></i> Delete
                                                        </router-link>
                                                    </v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </template>
                                </v-data-table-server>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useHead } from "@vueuse/head";
import { onMounted } from "vue";
import { StatusEnum } from "../../../enums/StatusEnum";
import { CouponTypeEnum } from "../../../enums/CouponTypeEnum";
import { useCoupons } from "../../../composables/useCoupons";

useHead({ title: 'Coupons' });

const {
    itemsPerPage,
    searchQuery,
    coupons,
    loading,
    totalCount,
    fetchCoupons,
    handleTableOptionsChange,
} = useCoupons();

const headers = [
    { align: 'start', key: 'code', sortable: true, title: 'Code' },
    { key: 'name', title: 'Name', sortable: false },
    { key: 'type', title: 'Type', sortable: false },
    { key: 'value', title: 'Value', sortable: true },
    { key: 'validity', title: 'Validity', sortable: false },
    { key: 'orders_count', title: 'Completed Orders', sortable: false },
    { key: 'status', title: 'Status', sortable: true },
    { key: 'created_at', title: 'Created At', sortable: true },
    { key: 'actions', title: 'Actions', sortable: false },
];

onMounted(() => {
    fetchCoupons();
});
</script>
