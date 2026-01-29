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
                                        <router-link :to="`/dash/users/${item.id}/show`" class="text-primary">
                                            {{ item.name }}
                                        </router-link>
                                    </template>

                                    <template #item.email="{ item }">
                                        {{ item.email }}
                                    </template>

                                    <template #item.phone="{ item }">
                                        {{ item.phone || '-' }}
                                    </template>

                                    <template #item.country="{ item }">
                                        {{ item.country?.name || '-' }}
                                    </template>

                                    <template #item.status="{ item }">
                                        <span class="badge" :class="StatusEnum.getClass(item.status)">
                                            {{ StatusEnum.getLabel(item.status) }}
                                        </span>
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
</template>

<script setup lang="ts">

import { useHead } from "@vueuse/head";
import { StatusEnum } from "../../../enums/StatusEnum";
import { useUsers } from "../../../composables/useUsers";
import { onMounted } from "vue";
import { formatDate } from "../../../main/date";

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

const headers = [
    {
        align: 'start',
        key: 'name',
        sortable: true,
        title: 'Name',
    },
    { key: 'email', title: 'Email', sortable: true },
    { key: 'phone', title: 'Phone', sortable: false },
    { key: 'country', title: 'Country', sortable: false },
    { key: 'created_at', title: 'Created At', sortable: true },
    { key: 'status', title: 'Status', sortable: true },
    { key: 'actions', title: 'Actions', sortable: false },
];

onMounted(() => {
    fetchUsers();
});

</script>
