<template>
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Settings Management
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="search_filter mb-4">
                        <div class="row">
                            <div class="col-md-4 d-flex">
                                <div class="search-input mb-4">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="search" v-model="searchQuery" class="form-control" placeholder="Search by slug or title...">
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
                                    :items="settings"
                                    :items-length="totalCount"
                                    :loading="loading"
                                    :search="searchQuery"
                                    item-value="slug"
                                    :items-per-page-options="[50, 100, 200, -1]"
                                    @update:options="handleTableOptionsChange"
                                >
                                    <template #item.title="{ item }">
                                        <div>
                                            <strong>{{ item.title?.en }}</strong>
                                            <br>
                                            <small class="text-muted">{{ item.title?.ar }}</small>
                                        </div>
                                    </template>

                                    <template #item.slug="{ item }">
                                        <code class="badge bg-secondary">{{ item.slug }}</code>
                                    </template>

                                    <template #item.content="{ item }">
                                        <div class="content-preview">
                                            <div v-if="item.content?.en">
                                                <small><strong>EN:</strong> {{ truncateContent(item.content.en, 50) }}</small>
                                            </div>
                                            <div v-if="item.content?.ar">
                                                <small><strong>AR:</strong> {{ truncateContent(item.content.ar, 50) }}</small>
                                            </div>
                                        </div>
                                    </template>

                                    <template #item.created_at="{ item }">
                                        {{ formatDate(item.created_at) }}
                                    </template>

                                    <template #item.actions="{ item }">
                                        <v-menu>
                                            <template v-slot:activator="{ props }">
                                                <v-btn icon="mdi-dots-vertical" variant="text" v-bind="props"></v-btn>
                                            </template>

                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link :to="`/dash/settings/${item.id}/update`" class="text-primary">
                                                            <i title="edit" class="fe fe-edit me-2"></i> Edit
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
import { useSettings } from "../../../composables/useSettings";
import { onMounted } from "vue";

useHead({
    title: 'Settings Management',
});

const {
    settings,
    loading,
    totalCount,
    itemsPerPage,
    searchQuery,
    handleTableOptionsChange,
    fetchSettings,
} = useSettings();

const headers = [
    { title: 'ID', key: 'id', align: 'start', sortable: true },
    { title: 'Title', key: 'title', align: 'start', sortable: false },
    { title: 'Slug', key: 'slug', align: 'start', sortable: true },
    { title: 'Content Preview', key: 'content', align: 'start', sortable: false },
    { title: 'Created At', key: 'created_at', align: 'start', sortable: true },
    { title: 'Actions', key: 'actions', align: 'center', sortable: false },
];

/**
 * Format date string
 */
const formatDate = (dateString: string): string => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

/**
 * Truncate long content for preview
 */
const truncateContent = (content: string, length: number = 50): string => {
    if (!content) return '';
    // Remove HTML tags for preview
    const text = content.replace(/<[^>]*>/g, '');
    return text.length > length ? text.substring(0, length) + '...' : text;
};

onMounted(() => {
    fetchSettings();
});

</script>

<style scoped>
.content-preview {
    max-width: 300px;
    font-size: 0.875rem;
}

.content-preview small {
    display: block;
    margin-bottom: 0.25rem;
}

code.badge {
    font-family: monospace;
    font-size: 0.875rem;
}
</style>



