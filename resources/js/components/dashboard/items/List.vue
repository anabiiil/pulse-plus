<template>
    <div class="col-xl-12">
        <div class="text-end my-4 d-flex align-items-center justify-content-end gap-2 flex-wrap">
            <button
                v-if="selected.length > 0"
                class="btn btn-success btn-b"
                :disabled="downloading"
                @click="downloadSelected"
            >
                <i class="fe fe-download me-1"></i>
                {{ downloading ? 'Downloading...' : `Download QR (${selected.length})` }}
            </button>
            <BulkCreate @created="fetchItems" />
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
                                    v-model="selected"
                                    :headers="headers"
                                    :items="items"
                                    :items-length="totalCount"
                                    :loading="loading"
                                    :search="searchQuery"
                                    item-value="id"
                                    show-select
                                    :items-per-page-options="[50, 100, 200, 300, 500, -1]"
                                    @update:options="handleTableOptionsChange"
                                >
                                    <template #item.created_at="{ item }">
                                        {{ $formatDate(item.created_at) }}
                                    </template>

                                    <template #item.type="{ item }">
                                        <span v-if="item.type" class="badge bg-secondary">{{ item.type }}</span>
                                        <span v-else class="text-muted fst-italic">—</span>
                                    </template>

                                    <template #item.code="{ item }">
                                        <code v-if="item.code" class="fw-bold text-primary">{{ item.code }}</code>
                                        <span v-else class="text-muted fst-italic">—</span>
                                    </template>

                                    <template #item.uuid="{ item }">
                                        <code class="text-muted fs-12">{{ item.uuid }}</code>
                                    </template>

                                    <template #item.status="{ item }">
                                        <span class="badge" :class="item.status_color">
                                            {{ item.status_label }}
                                        </span>
                                    </template>

                                    <template #item.user="{ item }">
                                        <span v-if="item.user?.name" class="fw-semibold">{{ item.user.name }}</span>
                                        <span v-else class="text-muted fst-italic">—</span>
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
import { onMounted, ref, computed } from 'vue';
import BulkCreate from './crud/BulkCreate.vue';

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

const selected = ref<number[]>([]);
const downloading = ref(false);

const selectedItems = computed(() =>
    items.value.filter((item: any) => selected.value.includes(item.id))
);

const downloadSelected = async () => {
    downloading.value = true;
    for (const item of selectedItems.value) {
        if (!item.qr_code_path) continue;
        try {
            const res = await fetch(item.qr_code_path);
            const blob = await res.blob();
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `item-qr-${item.code ?? item.uuid}.svg`;
            a.click();
            URL.revokeObjectURL(url);
            await new Promise(r => setTimeout(r, 150));
        } catch {
            // skip
        }
    }
    downloading.value = false;
};

const headers = [
    { key: 'id', title: 'ID', sortable: true },
    { key: 'code', title: 'Code', sortable: true },
    { key: 'type', title: 'Type', sortable: true },
    { key: 'uuid', title: 'UUID', sortable: false },
    { key: 'status', title: 'Status', sortable: true },
    { key: 'user', title: 'Assigned To', sortable: false },
    { key: 'created_at', title: 'Created At', sortable: true },
    { key: 'actions', title: 'Actions', sortable: false },
];

onMounted(() => {
    fetchItems();
});
</script>
