import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from "axios";

interface Nationality {
    id: number;
    name: any;
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

export const useNationalitiesStore = defineStore('nationalities', () => {
    // State
    const nationalities = ref<Nationality[]>([]);
    const nationality = ref<Nationality | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    // Getters
    const getNationalities = computed(() => nationalities.value);
    const getNationality = computed(() => nationality.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    // Actions
    /**
     * Fetch nationalities list with filters and pagination
     */
    const fetchNationalities = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/countries', {
                params: queryParams,
            });

            nationalities.value = response.data.data || [];
            meta.value = {
                total: response.data.pagination?.meta?.page?.total || 0,
                to: response.data.pagination?.meta?.page?.to || 0,
                from: response.data.pagination?.meta?.page?.from || 0,
                per_page: response.data.pagination?.meta?.page?.per_page || 50,
                last_page: response.data.pagination?.meta?.page?.last_page || 1,
                current_page: response.data.pagination?.meta?.page?.current_page || 1,
            };
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch nationalities';
            console.error('Error fetching nationalities:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch single nationality by ID
     */
    const fetchNationality = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/countries/${id}`);
            nationality.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch nationality';
            console.error('Error fetching nationality:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Create a new nationality
     */
    const createNationality = async (data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/countries', data);
            nationality.value = response.data.data || null;

            // Add new nationality to list
            if (response.data.data) {
                nationalities.value.unshift(response.data.data);
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to create nationality';
            console.error('Error creating nationality:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update existing nationality
     */
    const updateNationality = async (id: number, data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.patch(`/countries/${id}`, data);
            nationality.value = response.data.data || null;

            // Update in list
            const index = nationalities.value.findIndex((n) => n.id === id);
            if (index !== -1 && response.data.data) {
                nationalities.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update nationality';
            console.error('Error updating nationality:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Delete a nationality
     */
    const deleteNationality = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.delete(`/countries/${id}`);

            // Remove from list
            nationalities.value = nationalities.value.filter((n) => n.id !== id);
            nationality.value = null;

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to delete nationality';
            console.error('Error deleting nationality:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Clear store state
     */
    const clearState = () => {
        nationalities.value = [];
        nationality.value = null;
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
        nationalities,
        nationality,
        meta,
        loading,
        error,
        // Getters
        getNationalities,
        getNationality,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        // Actions
        fetchNationalities,
        fetchNationality,
        createNationality,
        updateNationality,
        deleteNationality,
        clearState,
        clearError,
    };
});
