import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from "axios";
import {formatDate} from "../main/date";

interface Service {
    id: number;
    name: any;
    description: any;
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

export const useServicesStore = defineStore('services', () => {
    // State
    const services = ref<Service[]>([]);
    const service = ref<Service | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    // Getters
    const getServices = computed(() => services.value);
    const getService = computed(() => service.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    // Actions
    /**
     * Fetch services list with filters and pagination
     */
    const fetchServices = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/services', {
                params: queryParams,
            });

            services.value = response.data.data || [];
            meta.value = {
                total: response.data.pagination?.meta?.page?.total || 0,
                to: response.data.pagination?.meta?.page?.to || 0,
                from: response.data.pagination?.meta?.page?.from || 0,
                per_page: response.data.pagination?.meta?.page?.per_page || 50,
                last_page: response.data.pagination?.meta?.page?.last_page || 1,
                current_page: response.data.pagination?.meta?.page?.current_page || 1,
            };
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch services';
            console.error('Error fetching services:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch single service by ID
     */
    const fetchService = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/services/${id}`);
            service.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch service';
            console.error('Error fetching service:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Create a new service
     */
    const createService = async (data: FormData | object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/services', data, {
                headers: data instanceof FormData ? { 'Content-Type': 'multipart/form-data' } : {},
            });
            service.value = response.data.data || null;

            // Add new service to list
            if (response.data.data) {
                services.value.unshift(response.data.data);
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to create service';
            console.error('Error creating service:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update existing service
     */
    const updateService = async (id: number, data: FormData | object) => {
        try {
            loading.value = true;
            error.value = null;
            if ("append" in data) {
                data.append('_method', 'PUT');
            }
            const response = await axios.post(`/services/${id}`, data, {
                headers: data instanceof FormData
                    ? { 'Content-Type': 'multipart/form-data' }
                    : {},
            });
            service.value = response.data.data || null;

            // Update in list
            const index = services.value.findIndex((s) => s.id === id);
            if (index !== -1 && response.data.data) {
                services.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update service';
            console.error('Error updating service:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Delete a service
     */
    const deleteService = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.delete(`/services/${id}`);

            // Remove from list
            services.value = services.value.filter((s) => s.id !== id);
            service.value = null;

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to delete service';
            console.error('Error deleting service:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Clear store state
     */
    const clearState = () => {
        services.value = [];
        service.value = null;
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
        services,
        service,
        meta,
        loading,
        error,
        // Getters
        getServices,
        getService,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        // Actions
        fetchServices,
        fetchService,
        createService,
        updateService,
        deleteService,
        clearState,
        clearError,
    };
});
