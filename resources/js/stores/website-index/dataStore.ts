import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

export const useDataStore = defineStore('website-index-data', () => {
    // State
    const sliders = ref([]);
    const products = ref([]);
    const services = ref([]);
    const settings = ref({});
    const isDataLoading = ref(false);

    // Actions
    async function fetchSliders() {
        try {
            isDataLoading.value = true;
            const response = await axios.get('/api/website/sliders');
            sliders.value = response.data.data || [];
        } catch (error) {
            console.error('Error fetching sliders:', error);
            sliders.value = [];
        } finally {
            isDataLoading.value = false;
        }
    }

    async function fetchProducts() {
        try {
            isDataLoading.value = true;
            const response = await axios.get('/api/website/products', {
                params: { limit: 10 }  // Get limited products for homepage
            });
            products.value = response.data.data || [];
        } catch (error) {
            console.error('Error fetching products:', error);
            products.value = [];
        } finally {
            isDataLoading.value = false;
        }
    }

    async function fetchServices() {
        try {
            isDataLoading.value = true;
            const response = await axios.get('/api/website/services', {
                params: { limit: 10 }  // Get limited services for homepage
            });
            services.value = response.data.data || [];
        } catch (error) {
            console.error('Error fetching services:', error);
            services.value = [];
        } finally {
            isDataLoading.value = false;
        }
    }

    async function fetchSettings() {
        try {
            isDataLoading.value = true;
            const response = await axios.get('/api/website/settings/all');

            // The API returns settings as key-value pairs (slug => {id, title, content})
            settings.value = response.data.data || {};
        } catch (error) {
            console.error('Error fetching settings:', error);
            // Fallback to mock data if API fails
            settings.value = {
                phone: { content: '+2 01022335566' },
                email: { content: 'info@pulse-plus.com' },
            };
        } finally {
            isDataLoading.value = false;
        }
    }

    async function initData() {
        await Promise.all([
            fetchSliders(),
            fetchProducts(),
            fetchServices(),
            fetchSettings(),
        ]);
    }

    return {
        // State
        sliders,
        products,
        services,
        settings,
        isDataLoading,
        // Actions
        fetchSliders,
        fetchProducts,
        fetchServices,
        fetchSettings,
        initData,
    };
});


