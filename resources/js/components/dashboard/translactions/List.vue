<template>
    <div class="col-md-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    Translations
                </div>

            </div>
            <div class="card-body">
                <div class="my-4">
                    <button class="btn mx-2" :class="type === 'en' ? 'btn-success' : 'btn-outline-success'"
                            @click.prevent="handleData('en')">EN
                    </button>
                    <button class="btn mx-2" :class="type === 'ar' ? 'btn-info' : 'btn-outline-info'"
                            @click.prevent="handleData('ar')">AR
                    </button>
                </div>
                <form class="table-responsive" method="post" @submit.prevent="submitData">
                    <div id="hidden-columns_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <div class="row mt-4" v-for="(item,index) in formData.trans">

                            <div class="col-3">
                                {{ item.key }}
                            </div>

                            <div class="col-9">
                                <input v-model="item.value" class="form-control">
                            </div>

                        </div>

                    </div>
                    <div class="col-12 mt-4 text-center">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</template>
<script>

import eventBus from "../../../main/event-bus.ts";
import {useHead} from "@vueuse/head";
import {FixtureStatusEnum} from "../../../enums/FixtureStatusEnum";
import {PlayerStatusEnum} from "../../../enums/PlayerStatus";
import {getLabel, getClass} from '../../../enums/PlayerPositionEnum';

export default {
    computed: {},
    setup() {
        useHead({
            title: 'Fixtures',
        });

    },
    data: () => ({
        formData: {
            trans: [],
            lang: 'en',
        },
        itemsPerPage: 50,
        headers: [
            {align: 'start', key: 'key', title: 'Key', sortable: false},
            {key: 'value', title: 'Value', sortable: false},
            {key: 'actions', title: 'Actions', sortable: false},
        ],

        loading: true,
        type: 'en',
        get_data_loading: false,
        totalItems: 0,
        options: {},
        translations: [],
    }),

    methods: {
        async fetchData() {
            this.formData.trans = [];

            this.loading = true;
            await axios.get(`translations/${this.formData.lang}`, {
                params: {},
            }).then((response) => {


                // this.formData = entries;
                for (const [key, value] of Object.entries(response.data.data)) {
                    this.formData.trans.push({
                        key: key,
                        value: value,
                    })
                }
                // this.translations = response.data.data
            }).catch((error) => {
                console.error(error);
            }).finally(() => {
                this.loading = false;
            });
        },

        async submitData() {
            this.loading = true;
            await axios.post(`translations/update/${this.formData.lang}`, this.formData, {
                params: {},
            }).then((response) => {
                showSuccessToast('Translations updated successfully');
                // this.translations = response.data.data
            }).catch((error) => {
                console.error(error);
            }).finally(() => {
                this.loading = false;
            });
        },
        getLabel,
        getClass,
        handleData($lang) {
            this.type = $lang;
            this.formData.lang = $lang;
            this.fetchData();
        }
    },

    mounted() {
        this.fetchData();
    }

}
</script>
