<template>
    <v-container class="py-16">
        <v-btn
            color="primary"
            variant="text"
            :to="{ name: 'products' }"
            class="mb-4"
        >
            <v-icon>mdi-arrow-left</v-icon>
            Back to Products
        </v-btn>

        <v-row v-if="!loading && product">
            <v-col cols="12" md="8">
                <v-card elevation="2">
                    <v-img
                        :src="product.image_url"
                        height="400"
                        cover
                    ></v-img>
                    <v-card-title class="text-h4">{{ product.name }}</v-card-title>
                    <v-card-text>
                        <div class="text-body-1" v-html="product.description"></div>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card elevation="2">
                    <v-card-title>Product Information</v-card-title>
                    <v-card-text>
                        <p><strong>Status:</strong> {{ product.status }}</p>
                        <p><strong>Created:</strong> {{ formatDate(product.created_at) }}</p>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" block :to="{ name: 'contact' }">
                            Inquire Now
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
                <p class="text-h6">Product not found.</p>
                <v-btn color="primary" :to="{ name: 'products' }" class="mt-4">
                    Back to Products
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
const product = ref(null);
const loading = ref(true);

useHead({
    title: product.value?.name || 'Product Detail',
});

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString();
};

const fetchProduct = async () => {
    try {
        loading.value = true;
        const response = await axios.get(`/api/website/products/${route.params.id}`);
        product.value = response.data.data || response.data;
    } catch (error) {
        console.error('Error fetching product:', error);
        window.showErrorToast?.('Failed to load product details');
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchProduct();
});
</script>
