<template>

    <div class="col-xl-12">
        <div class="text-end my-4">
            <router-link to="/dash/nationality/create" class="btn btn-info me-2 btn-b">
                Create Nationality
            </router-link>
        </div>
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Nationalities
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
                                    :items="nationalities"
                                    :items-length="totalCount"
                                    :loading="loading"
                                    :search="searchQuery"
                                    item-value="name"
                                    :items-per-page-options="[50,100, 200, 300, 500, -1]"
                                    @update:options="handleTableOptionsChange"
                                >
                                    <template #item.created_at="{ item }">
                                        {{ $formatDate(item.created_at) }}
                                    </template>
                                    <template #item.name="{ item }">
                                        <router-link :to="`/dash/nationality/${item.id}/update`"
                                                     class="text-primary">
                                            {{ item.name?.en }}
                                        </router-link>
                                    </template>

                                    <template #item.status="{ item }">
                                        <span class="badge"
                                              :class="StatusEnum.getClass(item.status)">
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
                                                        <router-link :to="`/dash/nationality/${item.id}/update`"
                                                                     class="text-primary">
                                                            <i title="edit" class="fe fe-edit me-2"></i> Edit
                                                        </router-link>
                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-title>
                                                        <router-link
                                                            :to="{ path: `/dash/nationality/${item.id}/delete`}"
                                                            class="text-danger">
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
<script setup>

import { useHead } from "@vueuse/head";
import { StatusEnum } from "../../../enums/StatusEnum";
import { useNationalities } from "../../../composables/useNationalities";
import { onMounted } from "vue";

useHead({
    title: 'Nationalities',
});

// Use nationalities composable
const {
    itemsPerPage,
    searchQuery,
    nationalities,
    loading,
    totalCount,
    fetchNationalities,
    handleTableOptionsChange,
} = useNationalities();

// Table headers configuration
const headers = [
    {
        align: 'start',
        key: 'name',
        sortable: true,
        title: 'Name',
    },
    { key: 'created_at', title: 'Created At', sortable: true },
    { key: 'status', title: 'Status', sortable: true },
    { key: 'actions', title: 'Actions', sortable: false },
];

// Lifecycle hook - fetch data on mount
onMounted(() => {
    fetchNationalities();
});

</script>
