import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from "axios";

interface Setting {
    id: number;
    title: any;
    slug: string;
    content: any;
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

export const useSettingsStore = defineStore('settings', () => {
    // State
    const settings = ref<Setting[]>([]);
    const setting = ref<Setting | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    // Getters
    const getSettings = computed(() => settings.value);
    const getSetting = computed(() => setting.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    // Actions
    /**
     * Fetch settings list with filters and pagination
     */
    const fetchSettings = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/settings', {
                params: queryParams,
            });

            settings.value = response.data.data || [];
            meta.value = {
                total: response.data.pagination?.meta?.page?.total || 0,
                to: response.data.pagination?.meta?.page?.to || 0,
                from: response.data.pagination?.meta?.page?.from || 0,
                per_page: response.data.pagination?.meta?.page?.per_page || 50,
                last_page: response.data.pagination?.meta?.page?.last_page || 1,
                current_page: response.data.pagination?.meta?.page?.current_page || 1,
            };
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch settings';
            console.error('Error fetching settings:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch single setting by ID
     */
    const fetchSetting = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/settings/${id}`);
            setting.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch setting';
            console.error('Error fetching setting:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch setting by slug
     */
    const fetchSettingBySlug = async (slug: string) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/settings/slug/${slug}`);
            setting.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch setting';
            console.error('Error fetching setting by slug:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update existing setting
     */
    const updateSetting = async (id: number, data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.put(`/settings/${id}`, data);
            setting.value = response.data.data || null;

            // Update in list
            const index = settings.value.findIndex((s) => s.id === id);
            if (index !== -1 && response.data.data) {
                settings.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update setting';
            console.error('Error updating setting:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Clear store state
     */
    const clearState = () => {
        settings.value = [];
        setting.value = null;
        meta.value = null;
        error.value = null;
    };

    return {
        // State
        settings,
        setting,
        meta,
        loading,
        error,
        // Getters
        getSettings,
        getSetting,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        // Actions
        fetchSettings,
        fetchSetting,
        fetchSettingBySlug,
        updateSetting,
        clearState,
    };
});

