import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

interface Item {
    id: number;
    uuid: string;
    name: string | null;
    type: 'C' | 'N' | 'B' | 'D' | null;
    code: string | null;
    status: 'active' | 'inactive' | 'used';
    status_label: string;
    status_color: string;
    qr_code: string | null;
    qr_code_path: string | null;
    user?: { id: number; name: string } | null;
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

export const useItemsStore = defineStore('items', () => {
    // State
    const items = ref<Item[]>([]);
    const item = ref<Item | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    // Getters
    const getItems = computed(() => items.value);
    const getItem = computed(() => item.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    /**
     * Fetch items list with filters and pagination
     */
    const fetchItems = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/items', { params: queryParams });

            items.value = response.data.data || [];
            meta.value = {
                total: response.data.pagination?.meta?.page?.total || 0,
                to: response.data.pagination?.meta?.page?.to || 0,
                from: response.data.pagination?.meta?.page?.from || 0,
                per_page: response.data.pagination?.meta?.page?.per_page || 50,
                last_page: response.data.pagination?.meta?.page?.last_page || 1,
                current_page: response.data.pagination?.meta?.page?.current_page || 1,
            };
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch items';
            console.error('Error fetching items:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch single item by ID
     */
    const fetchItem = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/items/${id}`);
            item.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch item';
            console.error('Error fetching item:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Create a new item
     */
    const createItem = async (data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/items', data);
            item.value = response.data.data || null;

            if (response.data.data) {
                items.value.unshift(response.data.data);
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to create item';
            console.error('Error creating item:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update existing item
     */
    const updateItem = async (id: number, data: object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.put(`/items/${id}`, data);
            item.value = response.data.data || null;

            const index = items.value.findIndex((i) => i.id === id);
            if (index !== -1 && response.data.data) {
                items.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update item';
            console.error('Error updating item:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Delete item
     */
    const deleteItem = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            await axios.delete(`/items/${id}`);
            items.value = items.value.filter((i) => i.id !== id);

            return true;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to delete item';
            console.error('Error deleting item:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    return {
        items,
        item,
        meta,
        loading,
        error,
        getItems,
        getItem,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        fetchItems,
        fetchItem,
        createItem,
        updateItem,
        deleteItem,
    };
});

