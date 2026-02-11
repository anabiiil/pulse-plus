import { defineStore } from 'pinia';
import { ref } from 'vue';

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
            // Replace with your actual API endpoint
            // const response = await axios.get('/api/sliders');
            // sliders.value = response.data;

            // Mock data for now
            sliders.value = [];
        } catch (error) {
            console.error('Error fetching sliders:', error);
        } finally {
            isDataLoading.value = false;
        }
    }

    async function fetchProducts() {
        try {
            isDataLoading.value = true;
            // Replace with your actual API endpoint
            // const response = await axios.get('/api/products');
            // products.value = response.data;

            // Mock data for now
            products.value = [];
        } catch (error) {
            console.error('Error fetching products:', error);
        } finally {
            isDataLoading.value = false;
        }
    }

    async function fetchServices() {
        try {
            isDataLoading.value = true;
            // Replace with your actual API endpoint
            // const response = await axios.get('/api/services');
            // services.value = response.data;

            // Mock data for now
            services.value = [];
        } catch (error) {
            console.error('Error fetching services:', error);
        } finally {
            isDataLoading.value = false;
        }
    }

    async function fetchSettings() {
        try {
            isDataLoading.value = true;
            // Replace with your actual API endpoint
            // const response = await axios.get('/api/settings');
            // settings.value = response.data;

            // Mock data for now
            settings.value = {
                phone: '+2 01022335566',
                email: 'info@pulse-plus.com',
            };
        } catch (error) {
            console.error('Error fetching settings:', error);
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


