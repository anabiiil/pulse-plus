import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from "axios";

interface Slider {
    id: number;
    title: any;
    desc: any;
    status: string;
    image_url?: string;
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

export const useSlidersStore = defineStore('sliders', () => {
    // State
    const sliders = ref<Slider[]>([]);
    const slider = ref<Slider | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    // Getters
    const getSliders = computed(() => sliders.value);
    const getSlider = computed(() => slider.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    // Actions
    /**
     * Fetch sliders list with filters and pagination
     */
    const fetchSliders = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/sliders', {
                params: queryParams,
            });

            sliders.value = response.data.data || [];
            meta.value = {
                total: response.data.pagination?.meta?.page?.total || 0,
                to: response.data.pagination?.meta?.page?.to || 0,
                from: response.data.pagination?.meta?.page?.from || 0,
                per_page: response.data.pagination?.meta?.page?.per_page || 50,
                last_page: response.data.pagination?.meta?.page?.last_page || 1,
                current_page: response.data.pagination?.meta?.page?.current_page || 1,
            };
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch sliders';
            console.error('Error fetching sliders:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch single slider by ID
     */
    const fetchSlider = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/sliders/${id}`);
            slider.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch slider';
            console.error('Error fetching slider:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Create a new slider
     */
    const createSlider = async (data: FormData | object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/sliders', data, {
                headers: data instanceof FormData ? { 'Content-Type': 'multipart/form-data' } : {},
            });
            slider.value = response.data.data || null;

            // Add new slider to list
            if (response.data.data) {
                sliders.value.unshift(response.data.data);
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to create slider';
            console.error('Error creating slider:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update existing slider
     */
    const updateSlider = async (id: number, data: FormData | object) => {
        try {
            loading.value = true;
            error.value = null;
            if ("append" in data) {
                data.append('_method', 'PUT');
            }
            const response = await axios.post(`/sliders/${id}`, data, {
                headers: data instanceof FormData
                    ? { 'Content-Type': 'multipart/form-data' }
                    : {},
            });
            slider.value = response.data.data || null;

            // Update in list
            const index = sliders.value.findIndex((s) => s.id === id);
            if (index !== -1 && response.data.data) {
                sliders.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update slider';
            console.error('Error updating slider:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Delete a slider
     */
    const deleteSlider = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.delete(`/sliders/${id}`);

            // Remove from list
            sliders.value = sliders.value.filter((s) => s.id !== id);
            slider.value = null;

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to delete slider';
            console.error('Error deleting slider:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Clear store state
     */
    const clearState = () => {
        sliders.value = [];
        slider.value = null;
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
        sliders,
        slider,
        meta,
        loading,
        error,
        // Getters
        getSliders,
        getSlider,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        // Actions
        fetchSliders,
        fetchSlider,
        createSlider,
        updateSlider,
        deleteSlider,
        clearState,
        clearError,
    };
});
