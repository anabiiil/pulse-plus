<template>
    <v-container class="py-16">
        <h1 class="text-h3 mb-8">Our Products</h1>

        <v-row v-if="!loading">
            <v-col
                v-for="product in products"
                :key="product.id"
                cols="12"
                md="4"
            >
                <v-card class="h-100" elevation="2">
                    <v-img
                        :src="product.image_url"
                        height="250"
                        cover
                    ></v-img>
                    <v-card-title>{{ product.name }}</v-card-title>
                    <v-card-text>
                        <p>{{ product.description?.substring(0, 100) }}...</p>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            color="primary"
                            :to="{ name: 'product.detail', params: { id: product.id } }"
                        >
                            View Details
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

        <v-row v-else>
            <v-col cols="12" class="text-center py-16">
                <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
            </v-col>
        </v-row>

        <v-row v-if="!loading && products.length === 0">
            <v-col cols="12" class="text-center">
                <p class="text-h6">No products available at the moment.</p>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useHead } from '@vueuse/head';
import axios from 'axios';

useHead({
    title: 'Products',
});

const products = ref([]);
const loading = ref(true);

const fetchProducts = async () => {
    try {
        loading.value = true;
        const response = await axios.get('/api/products', {
            params: {
                status: 'active'
            }
        });
        products.value = response.data.data || response.data;
    } catch (error) {
        console.error('Error fetching products:', error);
        window.showErrorToast?.('Failed to load products');
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchProducts();
});
</script>

<style scoped>
.h-100 {
    height: 100%;
}
</style>
