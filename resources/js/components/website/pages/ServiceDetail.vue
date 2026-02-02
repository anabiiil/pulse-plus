<template>
    <v-container class="py-16">
        <v-btn
            color="primary"
            variant="text"
            :to="{ name: 'services' }"
            class="mb-4"
        >
            <v-icon>mdi-arrow-left</v-icon>
            Back to Services
        </v-btn>

        <v-row v-if="!loading && service">
            <v-col cols="12" md="8">
                <v-card elevation="2">
                    <v-img
                        :src="service.image_url"
                        height="400"
                        cover
                    ></v-img>
                    <v-card-title class="text-h4">{{ service.name }}</v-card-title>
                    <v-card-text>
                        <div class="text-body-1" v-html="service.description"></div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card elevation="2">
                    <v-card-title>Service Information</v-card-title>
                    <v-card-text>
                        <p><strong>Status:</strong> {{ service.status }}</p>
                        <p><strong>Created:</strong> {{ formatDate(service.created_at) }}</p>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" block :to="{ name: 'contact' }">
                            Contact Us
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

        <v-row v-else-if="loading">
            <v-col cols="12" class="text-center py-16">
                <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
            </v-col>
        </v-row>

        <v-row v-else>
            <v-col cols="12" class="text-center">
                <p class="text-h6">Service not found.</p>
                <v-btn color="primary" :to="{ name: 'services' }" class="mt-4">
                    Back to Services
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useHead } from '@vueuse/head';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const service = ref(null);
const loading = ref(true);

useHead({
    title: service.value?.name || 'Service Detail',
});

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString();
};

const fetchService = async () => {
    try {
        loading.value = true;
        const response = await axios.get(`/api/services/${route.params.id}`);
        service.value = response.data.data || response.data;
    } catch (error) {
        console.error('Error fetching service:', error);
        window.showErrorToast?.('Failed to load service details');
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchService();
});
</script>
