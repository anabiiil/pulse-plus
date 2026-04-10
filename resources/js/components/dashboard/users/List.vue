<template>
    <div class="col-xl-12">
        <div class="text-end my-4">
            <router-link to="/dash/users/create" class="btn btn-info me-2 btn-b">
                Create User
            </router-link>
        </div>
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Users
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
                                    :items="users"
                                    :items-length="totalCount"
                                    :loading="loading"
                                    :search="searchQuery"
                                    item-value="name"
                                    :items-per-page-options="[50,100, 200, 300, 500, -1]"
                                    @update:options="handleTableOptionsChange"
                                >
                                    <template #item.created_at="{ item }">
                                        {{ formatDate(item.created_at) }}
                                    </template>

                                    <template #item.name="{ item }">
                                        <router-link :to="`/dash/users/${item.id}/show`" class="text-primary fw-semibold">
                                            {{ item.name }}
                                        </router-link>
                                    </template>

                                    <template #item.phone="{ item }">
                                        {{ item.phone || '-' }}
                                    </template>

                                    <template #item.country="{ item }">
                                        {{ item.country?.name || '-' }}
                                    </template>

                                    <template #item.item_link="{ item }">
                                        <a
                                            v-if="item.item?.uuid"
                                            :href="`https://pulse-plus.com/user/info/${item.item.uuid}`"
                                            target="_blank"
                                            class="text-info fw-semibold text-decoration-none"
                                        >
                                            <i class="fe fe-link me-1"></i>Item Link
                                        </a>
                                        <span v-else class="text-muted">-</span>
                                    </template>

                                    <template #item.subscription="{ item }">
                                        <div v-if="item.subscription">
                                            <div class="fw-semibold">{{ item.subscription.subscription_name }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">
                                                {{ item.subscription.start_date }} → {{ item.subscription.end_date }}

                                                <span class="badge" :class="item.subscription.status_color" style="font-size: 0.7rem;">
                                                {{ item.subscription.status_label }}
                                            </span>
                                            </div>

                                        </div>
                                        <span v-else class="text-muted">-</span>

                                    </template>

                                    <template #item.actions="{ item }">
                                        <v-menu>
                                            <template v-slot:activator="{ props }">
                                                <v-btn icon="mdi-dots-vertical" variant="text" v-bind="props"></v-btn>
                                            </template>

                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link :to="`/dash/users/${item.id}/show`" class="text-info">
                                                            <i title="view" class="fe fe-eye me-2"></i> View
                                                        </router-link>
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link :to="`/dash/users/${item.id}/edit`" class="text-primary">
                                                            <i title="edit" class="fe fe-edit me-2"></i> Edit
                                                        </router-link>
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item v-if="item.subscription">
                                                    <v-list-item-title>
                                                        <a href="#" class="text-warning" @click.prevent="openUpdateDates(item)">
                                                            <i class="fe fe-calendar me-2"></i> Update Dates
                                                        </a>
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item v-if="item.subscription">
                                                    <v-list-item-title>
                                                        <a href="#" class="text-success" @click.prevent="openRenew(item)">
                                                            <i class="fe fe-refresh-cw me-2"></i> Renew Plan
                                                        </a>
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link :to="{ path: `/dash/users/${item.id}/delete` }" class="text-danger">
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

    <UpdateSubscriptionDatesModal
        v-model="showUpdateDatesModal"
        :user="selectedUser"
        @updated="onSubscriptionUpdated"
    />

    <RenewSubscriptionModal
        v-model="showRenewModal"
        :user="selectedUser"
        @renewed="onSubscriptionUpdated"
    />
</template>

<script setup lang="ts">

import { ref, onMounted } from 'vue';
import { useHead } from "@vueuse/head";
import { StatusEnum } from "../../../enums/StatusEnum";
import { useUsers } from "../../../composables/useUsers";
import { formatDate } from "../../../main/date";
import UpdateSubscriptionDatesModal from "./modals/UpdateSubscriptionDatesModal.vue";
import RenewSubscriptionModal from "./modals/RenewSubscriptionModal.vue";

useHead({
    title: 'Users',
});

const {
    itemsPerPage,
    searchQuery,
    users,
    loading,
    totalCount,
    fetchUsers,
    handleTableOptionsChange,
} = useUsers();

const selectedUser = ref<any>(null);
const showUpdateDatesModal = ref(false);
const showRenewModal = ref(false);

const openUpdateDates = (user: any): void => {
    selectedUser.value = user;
    showUpdateDatesModal.value = true;
};

const openRenew = (user: any): void => {
    selectedUser.value = user;
    showRenewModal.value = true;
};

/**
 * Refresh the updated user row in the table in-place.
 */
const onSubscriptionUpdated = (updatedUser: any): void => {
    const index = users.value.findIndex((u: any) => u.id === updatedUser.id);
    if (index !== -1) {
        users.value[index] = updatedUser;
    }
};

const headers = [
    { align: 'start', key: 'name', sortable: true, title: 'Name' },
    { key: 'phone', title: 'Phone', sortable: false },
    { key: 'country', title: 'Country', sortable: false },
    { key: 'item_link', title: 'Item Link', sortable: false },
    { key: 'subscription', title: 'Subscription', sortable: false },
    { key: 'created_at', title: 'Created At', sortable: true },
    { key: 'status', title: 'Status', sortable: true },
    { key: 'actions', title: 'Actions', sortable: false },
];

onMounted(() => {
    fetchUsers();
});

</script>
