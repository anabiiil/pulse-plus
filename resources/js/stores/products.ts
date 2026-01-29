import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from "axios";

interface Product {
    id: number;
    name: any;
    description: any;
    price: number | null;
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

export const useProductsStore = defineStore('products', () => {
    // State
    const products = ref<Product[]>([]);
    const product = ref<Product | null>(null);
    const meta = ref<PaginationMeta | null>(null);
    const loading = ref<boolean>(false);
    const error = ref<string | null>(null);

    // Getters
    const getProducts = computed(() => products.value);
    const getProduct = computed(() => product.value);
    const getMeta = computed(() => meta.value);
    const isLoading = computed(() => loading.value);
    const getError = computed(() => error.value);
    const getTotalCount = computed(() => meta.value?.total || 0);

    // Actions
    /**
     * Fetch products list with filters and pagination
     */
    const fetchProducts = async (queryParams: object = {}) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get('/products', {
                params: queryParams,
            });

            products.value = response.data.data || [];
            meta.value = {
                total: response.data.pagination?.meta?.page?.total || 0,
                to: response.data.pagination?.meta?.page?.to || 0,
                from: response.data.pagination?.meta?.page?.from || 0,
                per_page: response.data.pagination?.meta?.page?.per_page || 50,
                last_page: response.data.pagination?.meta?.page?.last_page || 1,
                current_page: response.data.pagination?.meta?.page?.current_page || 1,
            };
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch products';
            console.error('Error fetching products:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Fetch single product by ID
     */
    const fetchProduct = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.get(`/products/${id}`);
            product.value = response.data.data || null;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch product';
            console.error('Error fetching product:', err);
        } finally {
            loading.value = false;
        }
    };

    /**
     * Create a new product
     */
    const createProduct = async (data: FormData | object) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.post('/products', data, {
                headers: data instanceof FormData ? { 'Content-Type': 'multipart/form-data' } : {},
            });
            product.value = response.data.data || null;

            // Add new product to list
            if (response.data.data) {
                products.value.unshift(response.data.data);
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to create product';
            console.error('Error creating product:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Update existing product
     */
    const updateProduct = async (id: number, data: FormData | object) => {
        try {
            loading.value = true;
            error.value = null;
            if ("append" in data) {
                data.append('_method', 'PUT');
            }
            const response = await axios.post(`/products/${id}`, data, {
                headers: data instanceof FormData
                    ? { 'Content-Type': 'multipart/form-data' }
                    : {},
            });
            product.value = response.data.data || null;

            // Update in list
            const index = products.value.findIndex((p) => p.id === id);
            if (index !== -1 && response.data.data) {
                products.value[index] = response.data.data;
            }

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to update product';
            console.error('Error updating product:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Delete a product
     */
    const deleteProduct = async (id: number) => {
        try {
            loading.value = true;
            error.value = null;

            const response = await axios.delete(`/products/${id}`);

            // Remove from list
            products.value = products.value.filter((p) => p.id !== id);
            product.value = null;

            return response.data;
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to delete product';
            console.error('Error deleting product:', err);
            throw err;
        } finally {
            loading.value = false;
        }
    };

    /**
     * Clear store state
     */
    const clearState = () => {
        products.value = [];
        product.value = null;
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
        products,
        product,
        meta,
        loading,
        error,
        // Getters
        getProducts,
        getProduct,
        getMeta,
        isLoading,
        getError,
        getTotalCount,
        // Actions
        fetchProducts,
        fetchProduct,
        createProduct,
        updateProduct,
        deleteProduct,
        clearState,
        clearError,
    };
});
