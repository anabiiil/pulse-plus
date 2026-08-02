import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from "axios";

interface Governorate {
    id: number;
    name: any;
    delivery_price: number;
    status: string;
    created_at: string;
    updated_at: string;
}

interface PaginationMeta {
    total: number;
    to: number;
    from: number;
    per_page: number;
    last_page: number;
    current_page: number;
}

export const useGovernoratesStore = defineStore('governorates', () => {
    // State
    const governorates = ref<Governorate[]>([]);
    const governorate = ref<Governorate | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    // Getters
    const getGovernorates = computed(() => governorates.value);
    const getGovernorate = computed(() => governorate.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    // Actions
    /**
     * Fetch governorates list with filters and pagination
     */
    const fetchGovernorates = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/governorates', {
                params: queryParams,
            });

            governorates.value = response.data.data || [];
            meta.value = {
                total: response.data.pagination?.meta?.page?.total || 0,
                to: response.data.pagination?.meta?.page?.to || 0,
                from: response.data.pagination?.meta?.page?.from || 0,
                per_page: response.data.pagination?.meta?.page?.per_page || 50,
                last_page: response.data.pagination?.meta?.page?.last_page || 1,
                current_page: response.data.pagination?.meta?.page?.current_page || 1,
            };
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch governorates';
            console.error('Error fetching governorates:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch single governorate by ID
     */
    const fetchGovernorate = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/governorates/${id}`);
            governorate.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch governorate';
            console.error('Error fetching governorate:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Create a new governorate
     */
    const createGovernorate = async (data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/governorates', data);
            governorate.value = response.data.data || null;

            // Add new governorate to list
            if (response.data.data) {
                governorates.value.unshift(response.data.data);
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to create governorate';
            console.error('Error creating governorate:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update existing governorate
     */
    const updateGovernorate = async (id: number, data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.patch(`/governorates/${id}`, data);
            governorate.value = response.data.data || null;

            // Update in list
            const index = governorates.value.findIndex((g) => g.id === id);
            if (index !== -1 && response.data.data) {
                governorates.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update governorate';
            console.error('Error updating governorate:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Delete a governorate
     */
    const deleteGovernorate = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.delete(`/governorates/${id}`);

            // Remove from list
            governorates.value = governorates.value.filter((g) => g.id !== id);
            governorate.value = null;

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to delete governorate';
            console.error('Error deleting governorate:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Clear store state
     */
    const clearState = () => {
        governorates.value = [];
        governorate.value = null;
        meta.value = null;
        error.value = null;
    };

    /**
     * Clear error message
     */
    const clearError = () => {
        error.value = null;
    };

    return {
        // State
        governorates,
        governorate,
        meta,
        loading,
        error,
        // Getters
        getGovernorates,
        getGovernorate,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        // Actions
        fetchGovernorates,
        fetchGovernorate,
        createGovernorate,
        updateGovernorate,
        deleteGovernorate,
        clearState,
        clearError,
    };
});
