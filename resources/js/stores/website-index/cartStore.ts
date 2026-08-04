import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

interface CartItem {
    id: number;
    product_id: number;
    name: string;
    price: number;
    image_url: string | null;
    quantity: number;
    line_total: number;
}

export const useCartStore = defineStore('website-index-cart', () => {
    // State
    const items = ref<CartItem[]>([]);
    const count = ref(0);
    const subtotal = ref(0);
    const loading = ref(false);
    const loaded = ref(false);

    // Getters
    const isEmpty = computed(() => items.value.length === 0);

    /**
     * Apply a cart payload returned by the API.
     */
    function setFromPayload(payload: any) {
        items.value = payload?.items || [];
        count.value = payload?.count || 0;
        subtotal.value = payload?.subtotal || 0;
    }

    /**
     * Fetch the current user's cart.
     */
    async function fetchCart() {
        try {
            loading.value = true;
            const response = await axios.get('/api/website/cart');
            setFromPayload(response.data.data);
            loaded.value = true;
        } catch (error) {
            // 302/401 when not authenticated — keep cart empty silently
            items.value = [];
            count.value = 0;
            subtotal.value = 0;
        } finally {
            loading.value = false;
        }
    }

    /**
     * Add a product to the cart.
     */
    async function addItem(productId: number, quantity: number = 1) {
        loading.value = true;
        try {
            const response = await axios.post('/api/website/cart', {
                product_id: productId,
                quantity,
            });
            setFromPayload(response.data.data);
            loaded.value = true;
            return response.data;
        } finally {
            loading.value = false;
        }
    }

    /**
     * Update a cart item quantity.
     */
    async function updateItem(itemId: number, quantity: number) {
        loading.value = true;
        try {
            const response = await axios.patch(`/api/website/cart/${itemId}`, { quantity });
            setFromPayload(response.data.data);
            return response.data;
        } finally {
            loading.value = false;
        }
    }

    /**
     * Remove a cart item.
     */
    async function removeItem(itemId: number) {
        loading.value = true;
        try {
            const response = await axios.delete(`/api/website/cart/${itemId}`);
            setFromPayload(response.data.data);
            return response.data;
        } finally {
            loading.value = false;
        }
    }

    /**
     * Empty the cart.
     */
    async function clear() {
        loading.value = true;
        try {
            const response = await axios.delete('/api/website/cart');
            setFromPayload(response.data.data);
            return response.data;
        } finally {
            loading.value = false;
        }
    }

    /**
     * Reset local cart state (e.g. on logout).
     */
    function reset() {
        items.value = [];
        count.value = 0;
        subtotal.value = 0;
        loaded.value = false;
    }

    return {
        // State
        items,
        count,
        subtotal,
        loading,
        loaded,
        // Getters
        isEmpty,
        // Actions
        fetchCart,
        addItem,
        updateItem,
        removeItem,
        clear,
        reset,
        setFromPayload,
    };
});
