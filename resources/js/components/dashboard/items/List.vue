<template>
    <div class="col-xl-12">
        <div class="text-end my-4">
            <router-link to="/dash/items/create" class="btn btn-info me-2 btn-b">
                Create Item
            </router-link>
        </div>
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">Items</div>
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

                    <div id="items-table_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <div class="row">
                            <div class="col-sm-12">
                                <v-data-table-server
                                    v-model:items-per-page="itemsPerPage"
                                    :headers="headers"
                                    :items="items"
                                    :items-length="totalCount"
                                    :loading="loading"
                                    :search="searchQuery"
                                    item-value="id"
                                    :items-per-page-options="[50, 100, 200, 300, 500, -1]"
                                    @update:options="handleTableOptionsChange"
                                >
                                    <template #item.created_at="{ item }">
                                        {{ $formatDate(item.created_at) }}
                                    </template>

                                    <template #item.name="{ item }">
                                        <span v-if="item.name">{{ item.name }}</span>
                                        <span v-else class="text-muted fst-italic">—</span>
                                    </template>

                                    <template #item.uuid="{ item }">
                                        <code class="text-muted fs-12">{{ item.uuid }}</code>
                                    </template>

                                    <template #item.status="{ item }">
                                        <span class="badge" :class="item.status ? 'bg-success' : 'bg-danger'">
                                            {{ item.status ? 'Active' : 'Inactive' }}
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
                                                        <router-link :to="`/dash/items/${item.id}/show`" class="text-info">
                                                            <i class="fe fe-eye me-2"></i> View QR
                                                        </router-link>
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link :to="`/dash/items/${item.id}/edit`" class="text-primary">
                                                            <i class="fe fe-edit me-2"></i> Edit
                                                        </router-link>
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link :to="`/dash/items/${item.id}/delete`" class="text-danger">
                                                            <i class="fe fe-trash me-2"></i> Delete
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
import { useHead } from '@vueuse/head';
import { useItems } from '../../../composables/useItems';
import { onMounted } from 'vue';

useHead({ title: 'Items' });

const {
    itemsPerPage,
    searchQuery,
    items,
    loading,
    totalCount,
    fetchItems,
    handleTableOptionsChange,
} = useItems();

const headers = [
    { key: 'id', title: 'ID', sortable: true },
    { key: 'name', title: 'Name', sortable: true },
    { key: 'uuid', title: 'UUID', sortable: false },
    { key: 'status', title: 'Status', sortable: true },
    { key: 'created_at', title: 'Created At', sortable: true },
    { key: 'actions', title: 'Actions', sortable: false },
];

onMounted(() => {
    fetchItems();
});
</script>

