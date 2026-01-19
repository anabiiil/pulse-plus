<template>

    <div class="col-xl-12">
        <div class="text-end my-4">
            <router-link to="/dash/country/create" class="btn btn-info me-2 btn-b">
                Create Countries
            </router-link>

            <router-link to="/dash/country/import" class="btn btn-success me-2 btn-b">
                Import
            </router-link>

            <a href="https://haddaf.net/admin/country/export" class="btn btn-secondary me-2 btn-b">
                Export
            </a>
        </div>
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Countries
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="search_filter mb-4">
                        <div class="row">
                            <div class="col-md-4 d-flex">
                                <div class="search-input mb-4">
                                    <label for="search" class="form-label">Search</label>
                                    <input type="search" v-model="search" class="form-control">
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
                                    :items="serverItems"
                                    :items-length="totalItems"
                                    :loading="loading"
                                    :search="search"
                                    item-value="name"
                                    :items-per-page-options="[50,100, 200, 300, 500, -1]"
                                    @update:options="loadItems"
                                >
                                    <template #item.created_at="{ item }">
                                        {{ $formatDate(item.created_at) }}
                                    </template>
                                    <template #item.name="{ item }">
                                        <router-link :to="`/dash/country/${item.id}/update`"
                                                     class="text-primary">
                                            {{ item.name?.en }}
                                        </router-link>
                                    </template>

                                    <template #item.region="{ item }">
                                            {{ item.region?.en }}
                                    </template>
                                    <template #item.subregion="{ item }">
                                            {{ item.subregion?.en }}
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
                                                        <router-link :to="`/dash/country/${item.id}/update`"
                                                                     class="text-primary">
                                                            <i title="edit" class="fe fe-edit me-2"></i> Edit
                                                        </router-link>

                                                    </v-list-item-title>
                                                </v-list-item>
                                                <v-list-item>
                                                    <v-list-item-title>

                                                        <router-link
                                                            :to="{ path: `/dash/country/${item.id}/delete`}"

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
<script>

import eventBus from "../../../main/event-bus.ts";
import {provide, ref} from "vue";
import {useHead} from "@vueuse/head";
import {StatusEnum} from "../../../enums/StatusEnum";

export default {
    computed: {
        StatusEnum() {
            return StatusEnum
        }
    },
    setup() {
        useHead({
            title: 'Countries',
        });
    },
    data: () => ({
        itemsPerPage: 50,
        headers: [
            {
                align: 'start',
                key: 'name',
                sortable: true,
                title: 'title',
            },
            {key: 'region', title: 'Region', sortable: true},
            {key: 'subregion', title: 'subregion', sortable: true},
            {key: 'iso3', title: 'Code', sortable: true},
            {key: 'phone_code', title: 'Phone Code', sortable: true},
            {key: 'status', title: 'Status',sortable: true},
            {key: 'actions', title: 'Actions', sortable: false},
        ],
        serverItems: [],
        loading: true,
        totalItems: 0,
        options: {},
        name: '',
        search: '',
        page: 1,

    }),

    methods: {
        loadItems({page, itemsPerPage, sortBy, search}) {
            this.page = page;
            this.options.sortBy = sortBy[0]?.key;
            this.options.sortDesc = sortBy[0]?.order;
            this.fetchData();
        },
        fetchData() {
            this.loading = true;
            axios.get('countries/list', {
                params: {
                    page: this.page,
                    per_page: this.itemsPerPage,
                    sortBy: this.options.sortBy,
                    sortDesc: this.options.sortDesc,
                    search: this.search,
                },
            }).then((response) => {
                // console.log(response.data.pagination.meta.page.total)
                this.serverItems = response.data.data
                this.totalItems = response.data.pagination.meta.page.total
                this.loading = false
            }).catch((error) => {
                console.error(error);
                this.loading = false;
            });
        },

    },

}
</script>
